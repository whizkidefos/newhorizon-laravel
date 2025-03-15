<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Timesheet::with(['user', 'shift']);

        // Filter by user
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->has('date') && $request->date) {
            $query->whereDate('date', $request->date);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        $timesheets = $query->latest()->paginate(15);
        $users = User::orderBy('first_name')->get();

        return view('admin.timesheets.index', compact('timesheets', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('first_name')->get();
        return view('admin.timesheets.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'break_duration' => 'required|numeric|min:0',
            'tasks_completed' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
            'rejection_reason' => 'nullable|required_if:status,rejected|string',
        ]);

        // Calculate hours worked
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = Carbon::parse($validated['end_time']);
        $hoursWorked = $endTime->diffInMinutes($startTime) / 60;
        
        // Subtract break duration
        $hoursWorked -= $validated['break_duration'];

        $timesheet = new Timesheet([
            'user_id' => $validated['user_id'],
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'hours_worked' => $hoursWorked,
            'break_duration' => $validated['break_duration'],
            'tasks_completed' => $validated['tasks_completed'],
            'notes' => $validated['notes'],
            'status' => $validated['status'],
            'rejection_reason' => $validated['rejection_reason'] ?? null,
        ]);

        $timesheet->save();

        return redirect()->route('admin.timesheets.index')
            ->with('success', 'Timesheet created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Timesheet $timesheet)
    {
        return view('admin.timesheets.show', compact('timesheet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Timesheet $timesheet)
    {
        $users = User::orderBy('first_name')->get();
        return view('admin.timesheets.edit', compact('timesheet', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Timesheet $timesheet)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'break_duration' => 'required|numeric|min:0',
            'tasks_completed' => 'nullable|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
            'rejection_reason' => 'nullable|required_if:status,rejected|string',
        ]);

        // Calculate hours worked
        $startTime = Carbon::parse($validated['start_time']);
        $endTime = Carbon::parse($validated['end_time']);
        $hoursWorked = $endTime->diffInMinutes($startTime) / 60;
        
        // Subtract break duration
        $hoursWorked -= $validated['break_duration'];

        $timesheet->update([
            'user_id' => $validated['user_id'],
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'hours_worked' => $hoursWorked,
            'break_duration' => $validated['break_duration'],
            'tasks_completed' => $validated['tasks_completed'],
            'notes' => $validated['notes'],
            'status' => $validated['status'],
            'rejection_reason' => $validated['rejection_reason'] ?? null,
        ]);

        return redirect()->route('admin.timesheets.index')
            ->with('success', 'Timesheet updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Timesheet $timesheet)
    {
        $timesheet->delete();

        return redirect()->route('admin.timesheets.index')
            ->with('success', 'Timesheet deleted successfully.');
    }

    /**
     * Export timesheets based on filters.
     */
    public function export(Request $request)
    {
        $query = Timesheet::with(['user', 'shift']);

        // Apply filters
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('date', $request->date);
        }

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('date', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('date', '<=', $request->end_date);
        }

        $timesheets = $query->get();
        
        // Determine export format
        $format = $request->format ?? 'csv';
        
        switch ($format) {
            case 'csv':
                return $this->exportCsv($timesheets);
            case 'excel':
                return $this->exportExcel($timesheets);
            case 'pdf':
                return $this->exportPdf($timesheets);
            default:
                return $this->exportCsv($timesheets);
        }
    }

    /**
     * Export timesheets as CSV.
     */
    private function exportCsv($timesheets)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="timesheets.csv"',
        ];

        $callback = function() use ($timesheets) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, [
                'ID', 'Employee', 'Date', 'Start Time', 'End Time', 
                'Hours Worked', 'Break Duration', 'Tasks Completed', 
                'Notes', 'Status', 'Submitted At'
            ]);
            
            // Add data
            foreach ($timesheets as $timesheet) {
                fputcsv($file, [
                    $timesheet->id,
                    $timesheet->user->full_name,
                    $timesheet->date->format('Y-m-d'),
                    $timesheet->start_time->format('H:i'),
                    $timesheet->end_time->format('H:i'),
                    $timesheet->hours_worked,
                    $timesheet->break_duration,
                    $timesheet->tasks_completed,
                    $timesheet->notes,
                    $timesheet->status,
                    $timesheet->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export timesheets as Excel.
     * Note: This requires the maatwebsite/excel package to be installed.
     */
    private function exportExcel($timesheets)
    {
        // Implementation would use Laravel Excel package
        // For now, fallback to CSV
        return $this->exportCsv($timesheets);
    }

    /**
     * Export timesheets as PDF.
     * Note: This requires a PDF package like dompdf to be installed.
     */
    private function exportPdf($timesheets)
    {
        // Implementation would use a PDF package
        // For now, fallback to CSV
        return $this->exportCsv($timesheets);
    }

    /**
     * Approve a timesheet.
     */
    public function approve(Timesheet $timesheet)
    {
        $timesheet->update([
            'status' => 'approved',
            'rejection_reason' => null,
        ]);

        return redirect()->back()->with('success', 'Timesheet approved successfully.');
    }

    /**
     * Reject a timesheet.
     */
    public function reject(Request $request, Timesheet $timesheet)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $timesheet->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return redirect()->back()->with('success', 'Timesheet rejected successfully.');
    }
}
