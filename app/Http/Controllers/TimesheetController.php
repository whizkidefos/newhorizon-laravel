<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $timesheets = Auth::user()->timesheets()->latest()->paginate(10);
        return view('timesheets.index', compact('timesheets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('timesheets.create');
    }

    /**
     * Create a timesheet from a shift.
     */
    public function createFromShift(Shift $shift)
    {
        return view('timesheets.create-from-shift', compact('shift'));
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
