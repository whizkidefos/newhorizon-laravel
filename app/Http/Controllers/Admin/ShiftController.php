<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\PDFGenerator;

class ShiftController extends Controller
{
    public function index(Request $request)
    {
        $shifts = Shift::query()
            ->when($request->status, function($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->date_from, function($query, $date) {
                $query->where('start_datetime', '>=', $date);
            })
            ->when($request->date_to, function($query, $date) {
                $query->where('start_datetime', '<=', $date);
            })
            ->when($request->location, function($query, $location) {
                $query->where('location', 'like', "%{$location}%");
            })
            ->with('user')
            ->latest('start_datetime')
            ->paginate(15);

        $locations = Shift::distinct('location')->pluck('location');

        return view('admin.shifts.index', compact('shifts', 'locations'));
    }

    public function create()
    {
        $users = User::role('user')->get();
        return view('admin.shifts.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'location' => 'required|string',
            'rate_per_hour' => 'required|numeric|min:0',
            'user_id' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        $shift = Shift::create($validated + [
            'status' => $request->user_id ? 'assigned' : 'open'
        ]);

        return redirect()->route('admin.shifts.index')
            ->with('success', 'Shift created successfully');
    }

    public function show(Shift $shift)
    {
        $shift->load('user');
        return view('admin.shifts.show', compact('shift'));
    }

    public function edit(Shift $shift)
    {
        $users = User::role('user')->get();
        return view('admin.shifts.edit', compact('shift', 'users'));
    }

    public function update(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'location' => 'required|string',
            'rate_per_hour' => 'required|numeric|min:0',
            'user_id' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        $shift->update($validated);

        return redirect()->route('admin.shifts.show', $shift)
            ->with('success', 'Shift updated successfully');
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();
        return redirect()->route('admin.shifts.index')
            ->with('success', 'Shift deleted successfully');
    }

    public function exportPdf(Request $request, PDFGenerator $pdfGenerator)
    {
        $shifts = Shift::query()
            ->when($request->status, function($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->date_from, function($query, $date) {
                $query->where('start_datetime', '>=', $date);
            })
            ->when($request->date_to, function($query, $date) {
                $query->where('start_datetime', '<=', $date);
            })
            ->with('user')
            ->get();

        return $pdfGenerator->generateShiftReport($shifts, $request->all());
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

        return redirect()->back()->with('success', 'Shift assigned successfully');
    }
}