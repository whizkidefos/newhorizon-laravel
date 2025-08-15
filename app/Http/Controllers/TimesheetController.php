<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = $user->timesheets();
        
        // Apply filters if they exist
        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Get paginated results
        $timesheets = $query->latest()->paginate(10);
        
        // Calculate dashboard statistics
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        
        // Total hours this month
        $totalHoursThisMonth = $user->timesheets()
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('hours_worked');
        
        // Approval rate
        $totalTimesheets = $user->timesheets()->count();
        $approvedTimesheets = $user->timesheets()->where('status', 'approved')->count();
        $approvalRate = $totalTimesheets > 0 ? round(($approvedTimesheets / $totalTimesheets) * 100) : 0;
        
        // Pending count
        $pendingCount = $user->timesheets()->where('status', 'pending')->count();
        
        return view('timesheets.index', compact(
            'timesheets', 
            'totalHoursThisMonth', 
            'approvalRate', 
            'pendingCount'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('timesheets.create');
    }
    
    /**
     * Show the form for quick timesheet submission (mobile-optimized).
     */
    public function quickSubmit()
    {
        return view('timesheets.quick-submit');
    }

    /**
     * Create a timesheet from a shift.
     */
    public function createFromShift(Shift $shift)
    {
        return view('timesheets.create-from-shift', compact('shift'));
    }
    
    /**
     * Quick submit a timesheet from a shift.
     */
    public function quickSubmitFromShift(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'break_duration' => 'required|numeric|min:0',
            'tasks_completed' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        
        // Calculate hours worked based on shift check-in and check-out times
        $startTime = Carbon::parse($shift->checkin_time);
        $endTime = Carbon::parse($shift->checkout_time);
        $hoursWorked = $endTime->diffInMinutes($startTime) / 60;
        
        // Subtract break duration
        $hoursWorked -= $validated['break_duration'];
        
        $timesheet = new Timesheet([
            'user_id' => Auth::id(),
            'shift_id' => $shift->id,
            'date' => $shift->start_datetime->format('Y-m-d'),
            'start_time' => $shift->checkin_time->format('H:i'),
            'end_time' => $shift->checkout_time->format('H:i'),
            'hours_worked' => $hoursWorked,
            'break_duration' => $validated['break_duration'],
            'tasks_completed' => $validated['tasks_completed'],
            'notes' => $validated['notes'],
            'status' => 'pending',
        ]);
        
        $timesheet->save();
        
        return redirect()->route('timesheets.index')
            ->with('success', 'Timesheet submitted successfully and is pending approval.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'break_duration' => 'required|numeric|min:0',
            'tasks_completed' => 'nullable|string',
            'notes' => 'nullable|string',
            'shift_id' => 'nullable|exists:shifts,id',
        ]);

        // Calculate hours worked
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = Carbon::parse($validated['end_time']);
        $hoursWorked = $endTime->diffInMinutes($startTime) / 60;
        
        // Subtract break duration
        $hoursWorked -= $validated['break_duration'];

        $timesheet = new Timesheet([
            'user_id' => Auth::id(),
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'hours_worked' => $hoursWorked,
            'break_duration' => $validated['break_duration'],
            'tasks_completed' => $validated['tasks_completed'],
            'notes' => $validated['notes'],
            'status' => 'pending',
        ]);

        if (isset($validated['shift_id'])) {
            $timesheet->shift_id = $validated['shift_id'];
        }

        $timesheet->save();

        return redirect()->route('timesheets.index')
            ->with('success', 'Timesheet submitted successfully and is pending approval.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Timesheet $timesheet)
    {
        $this->authorize('view', $timesheet);
        return view('timesheets.show', compact('timesheet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timesheet $timesheet)
    {
        $this->authorize('update', $timesheet);
        return view('timesheets.edit', compact('timesheet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Timesheet $timesheet)
    {
        $this->authorize('update', $timesheet);
        
        $validated = $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'break_duration' => 'required|numeric|min:0',
            'tasks_completed' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Calculate hours worked
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = Carbon::parse($validated['end_time']);
        $hoursWorked = $endTime->diffInMinutes($startTime) / 60;
        
        // Subtract break duration
        $hoursWorked -= $validated['break_duration'];

        $timesheet->update([
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'hours_worked' => $hoursWorked,
            'break_duration' => $validated['break_duration'],
            'tasks_completed' => $validated['tasks_completed'],
            'notes' => $validated['notes'],
            'status' => 'pending', // Reset to pending on update
        ]);

        return redirect()->route('timesheets.index')
            ->with('success', 'Timesheet updated successfully and is pending approval.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timesheet $timesheet)
    {
        $this->authorize('delete', $timesheet);
        
        $timesheet->delete();

        return redirect()->route('timesheets.index')
            ->with('success', 'Timesheet deleted successfully.');
    }
}
