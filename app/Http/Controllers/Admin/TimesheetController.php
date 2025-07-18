<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TimesheetController extends Controller
{
    /**
     * Display the timesheet dashboard with statistics and charts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function dashboard(Request $request)
    {
        // Determine date range for filtering
        $dateRange = $request->input('date_range', 'this_month');
        $dateFrom = null;
        $dateTo = null;
        
        switch ($dateRange) {
            case 'today':
                $dateFrom = Carbon::today();
                $dateTo = Carbon::today();
                break;
            case 'yesterday':
                $dateFrom = Carbon::yesterday();
                $dateTo = Carbon::yesterday();
                break;
            case 'this_week':
                $dateFrom = Carbon::now()->startOfWeek();
                $dateTo = Carbon::now()->endOfWeek();
                break;
            case 'last_week':
                $dateFrom = Carbon::now()->subWeek()->startOfWeek();
                $dateTo = Carbon::now()->subWeek()->endOfWeek();
                break;
            case 'this_month':
                $dateFrom = Carbon::now()->startOfMonth();
                $dateTo = Carbon::now()->endOfMonth();
                break;
            case 'last_month':
                $dateFrom = Carbon::now()->subMonth()->startOfMonth();
                $dateTo = Carbon::now()->subMonth()->endOfMonth();
                break;
            case 'this_year':
                $dateFrom = Carbon::now()->startOfYear();
                $dateTo = Carbon::now()->endOfYear();
                break;
            case 'custom':
                $dateFrom = $request->input('date_from') ? Carbon::parse($request->input('date_from')) : Carbon::now()->subMonth();
                $dateTo = $request->input('date_to') ? Carbon::parse($request->input('date_to')) : Carbon::now();
                break;
        }
        
        // Base query with date range filter
        $baseQuery = Timesheet::whereBetween('date', [$dateFrom, $dateTo]);
        
        // Get timesheet statistics
        $totalTimesheets = $baseQuery->count();
        $pendingTimesheets = $baseQuery->where('status', 'pending')->count();
        $approvedTimesheets = $baseQuery->where('status', 'approved')->count();
        $rejectedTimesheets = $baseQuery->where('status', 'rejected')->count();
        
        // Get recent timesheets
        $recentTimesheets = Timesheet::with(['user', 'shift'])
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->latest()
            ->take(10)
            ->get();
        
        // Prepare data for hours worked by day chart
        $hoursByDay = Timesheet::whereBetween('date', [$dateFrom, $dateTo])
            ->where('status', '!=', 'rejected')
            ->select(DB::raw('DATE(date) as day'), DB::raw('SUM(hours_worked) as total_hours'))
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day');
        
        // Format data for chart
        $days = [];
        $currentDate = clone $dateFrom;
        $hoursByDayLabels = [];
        $hoursByDayValues = [];
        
        // Limit to 14 days for better visualization if the range is large
        $maxDays = 14;
        $dayInterval = max(1, intval($dateFrom->diffInDays($dateTo) / $maxDays));
        
        while ($currentDate <= $dateTo) {
            $dayKey = $currentDate->format('Y-m-d');
            $hoursByDayLabels[] = $currentDate->format('M d');
            $hoursByDayValues[] = isset($hoursByDay[$dayKey]) ? round($hoursByDay[$dayKey]->total_hours, 2) : 0;
            
            $currentDate->addDays($dayInterval);
        }
        
        return view('admin.timesheets.dashboard', compact(
            'totalTimesheets',
            'pendingTimesheets',
            'approvedTimesheets',
            'rejectedTimesheets',
            'recentTimesheets',
            'hoursByDayLabels',
            'hoursByDayValues',
            'dateRange'
        ));
    }
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

        // Handle date range filtering
        if ($request->has('date_range') && $request->date_range) {
            switch ($request->date_range) {
                case 'today':
                    $query->whereDate('date', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('date', Carbon::yesterday());
                    break;
                case 'this_week':
                    $query->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'last_week':
                    $query->whereBetween('date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]);
                    break;
                case 'this_month':
                    $query->whereBetween('date', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                    break;
                case 'last_month':
                    $query->whereBetween('date', [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()]);
                    break;
                case 'this_year':
                    $query->whereBetween('date', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()]);
                    break;
            }
        } else {
            // Filter by specific date
            if ($request->has('date') && $request->date) {
                $query->whereDate('date', $request->date);
            }

            // Filter by custom date range
            if ($request->has('date_from') && $request->date_from) {
                $query->whereDate('date', '>=', $request->date_from);
            }

            if ($request->has('date_to') && $request->date_to) {
                $query->whereDate('date', '<=', $request->date_to);
            }
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
