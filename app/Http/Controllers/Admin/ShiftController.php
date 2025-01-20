<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ShiftRequest;

class ShiftController extends Controller
{
    public function index(Request $request)
    {
        $shifts = Shift::query()
            ->with('user')
            ->when($request->status, function($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->date_from, function($query, $date) {
                $query->whereDate('start_datetime', '>=', $date);
            })
            ->when($request->date_to, function($query, $date) {
                $query->whereDate('start_datetime', '<=', $date);
            })
            ->when($request->location, function($query, $location) {
                $query->where('location', 'like', "%{$location}%");
            })
            ->latest('start_datetime')
            ->paginate(15)
            ->withQueryString();

        return view('admin.shifts.index', [
            'shifts' => $shifts,
            'locations' => Shift::distinct('location')->pluck('location'),
            'statuses' => Shift::distinct('status')->pluck('status')
        ]);
    }

    public function create()
    {
        $users = User::where('is_admin', false)
            ->where('is_active', true)
            ->get();

        return view('admin.shifts.create', compact('users'));
    }

    public function store(ShiftRequest $request)
    {
        $shift = Shift::create($request->validated());

        if ($request->user_id) {
            // Send notification to assigned user
            $shift->user->notify(new ShiftAssigned($shift));
        }

        return redirect()
            ->route('admin.shifts.index')
            ->with('success', 'Shift created successfully');
    }

    public function show(Shift $shift)
    {
        $shift->load(['user', 'activities']);
        return view('admin.shifts.show', compact('shift'));
    }

    public function edit(Shift $shift)
    {
        $users = User::where('is_admin', false)
            ->where('is_active', true)
            ->get();

        return view('admin.shifts.edit', [
            'shift' => $shift,
            'users' => $users
        ]);
    }

    public function update(ShiftRequest $request, Shift $shift)
    {
        $oldUserId = $shift->user_id;
        $shift->update($request->validated());

        // If user assignment changed, send notifications
        if ($oldUserId !== $shift->user_id) {
            if ($oldUserId) {
                User::find($oldUserId)->notify(new ShiftUnassigned($shift));
            }
            if ($shift->user_id) {
                $shift->user->notify(new ShiftAssigned($shift));
            }
        }

        return redirect()
            ->route('admin.shifts.show', $shift)
            ->with('success', 'Shift updated successfully');
    }

    public function destroy(Shift $shift)
    {
        if ($shift->user_id) {
            $shift->user->notify(new ShiftCancelled($shift));
        }

        $shift->delete();

        return redirect()
            ->route('admin.shifts.index')
            ->with('success', 'Shift deleted successfully');
    }

    public function track(Shift $shift)
    {
        abort_if(!$shift->is_active, 404);
        
        return view('admin.shifts.track', compact('shift'));
    }

    public function assign(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $shift->update([
            'user_id' => $validated['user_id'],
            'status' => 'assigned'
        ]);

        // Notify assigned user
        $shift->user->notify(new ShiftAssigned($shift));

        return back()->with('success', 'Shift assigned successfully');
    }
}