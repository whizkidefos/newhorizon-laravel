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
        
        // Additional filters
        $selectedLocation = $request->input('location');
        $selectedDepartment = $request->input('department');
        
        // Base query with date range filter
        $baseQuery = Timesheet::whereBetween('date', [$dateFrom, $dateTo]);
        
        // Apply additional filters if provided
        if ($selectedLocation) {
            $baseQuery->whereHas('shift', function($query) use ($selectedLocation) {
                $query->where('location', $selectedLocation);
            });
        }
        
        if ($selectedDepartment) {
            $baseQuery->whereHas('user', function($query) use ($selectedDepartment) {
                $query->where('department', $selectedDepartment);
            });
        }
        
        // Get timesheet statistics
        $totalTimesheets = $baseQuery->count();
        $pendingTimesheets = $baseQuery->where('status', 'pending')->count();
        $approvedTimesheets = $baseQuery->where('status', 'approved')->count();
        $rejectedTimesheets = $baseQuery->where('status', 'rejected')->count();
        
        // Calculate total hours and average hours per timesheet
        $totalHoursWorked = $baseQuery->where('status', '!=', 'rejected')->sum('hours_worked');
        $avgHoursPerTimesheet = $totalTimesheets > 0 ? round($totalHoursWorked / $totalTimesheets, 2) : 0;
        
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
        
        // Get top 5 employees by hours worked
        $topEmployees = Timesheet::whereBetween('date', [$dateFrom, $dateTo])
            ->where('status', '!=', 'rejected')
            ->select('user_id', DB::raw('SUM(hours_worked) as total_hours'), DB::raw('COUNT(*) as timesheet_count'))
            ->groupBy('user_id')
            ->orderByDesc('total_hours')
            ->take(5)
            ->with('user')
            ->get();
            
        // Trend analysis - Compare current period with previous period
        $previousPeriodStart = (clone $dateFrom)->subDays($dateFrom->diffInDays($dateTo) + 1);
        $previousPeriodEnd = (clone $dateFrom)->subDay();
        
        $currentPeriodHours = $totalHoursWorked;
        
        $previousPeriodHours = Timesheet::whereBetween('date', [$previousPeriodStart, $previousPeriodEnd])
            ->where('status', '!=', 'rejected')
            ->sum('hours_worked');
            
        $hoursChange = $previousPeriodHours > 0 
            ? round((($currentPeriodHours - $previousPeriodHours) / $previousPeriodHours) * 100, 1) 
            : 0;
            
        // Get locations for filtering
        $locations = DB::table('shift_locations')->pluck('name');
        
        // Get departments for filtering
        $departments = User::distinct('department')->whereNotNull('department')->pluck('department');
        
        // Hours by location chart data
        $hoursByLocation = Timesheet::whereBetween('date', [$dateFrom, $dateTo])
            ->where('status', '!=', 'rejected')
            ->whereHas('shift', function($query) {
                $query->whereNotNull('location');
            })
            ->join('shifts', 'timesheets.shift_id', '=', 'shifts.id')
            ->select('shifts.location', DB::raw('SUM(timesheets.hours_worked) as total_hours'))
            ->groupBy('shifts.location')
            ->get();
            
        $locationLabels = $hoursByLocation->pluck('location')->toArray();
        $locationValues = $hoursByLocation->pluck('total_hours')->toArray();
        
        return view('admin.timesheets.dashboard', compact(
            'totalTimesheets',
            'pendingTimesheets',
            'approvedTimesheets',
            'rejectedTimesheets',
            'recentTimesheets',
            'hoursByDayLabels',
            'hoursByDayValues',
            'totalHoursWorked',
            'avgHoursPerTimesheet',
            'topEmployees',
            'hoursChange',
            'previousPeriodHours',
            'currentPeriodHours',
            'locations',
            'departments',
            'selectedLocation',
            'selectedDepartment',
            'locationLabels',
            'locationValues',
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
        
        // Additional filters for enhanced export
        if ($request->has('location') && $request->location) {
            $query->whereHas('shift', function($query) use ($request) {
                $query->where('location', $request->location);
            });
        }
        
        if ($request->has('department') && $request->department) {
            $query->whereHas('user', function($query) use ($request) {
                $query->where('department', $request->department);
            });
        }
        
        if ($request->has('min_hours') && is_numeric($request->min_hours)) {
            $query->where('hours_worked', '>=', $request->min_hours);
        }
        
        if ($request->has('max_hours') && is_numeric($request->max_hours)) {
            $query->where('hours_worked', '<=', $request->max_hours);
        }

        // Sort options
        $sortField = $request->input('sort_field', 'date');
        $sortDirection = $request->input('sort_direction', 'desc');
        
        // Validate sort field to prevent SQL injection
        $allowedSortFields = ['date', 'hours_worked', 'created_at', 'status'];
        if (!in_array($sortField, $allowedSortFields)) {
            $sortField = 'date';
        }
        
        $query->orderBy($sortField, $sortDirection === 'asc' ? 'asc' : 'desc');

        $timesheets = $query->get();
        
        // Add filename customization
        $filename = 'timesheets';
        if ($request->has('filename') && $request->filename) {
            $filename = preg_replace('/[^a-z0-9_-]/i', '_', $request->filename);
        } else {
            // Generate a descriptive filename based on filters
            if ($request->has('start_date') && $request->has('end_date')) {
                $filename .= '_' . $request->start_date . '_to_' . $request->end_date;
            } elseif ($request->has('date')) {
                $filename .= '_' . $request->date;
            }
            
            if ($request->has('status')) {
                $filename .= '_' . $request->status;
            }
        }
        
        // Determine export format
        $format = $request->format ?? 'csv';
        
        switch ($format) {
            case 'csv':
                return $this->exportCsv($timesheets, $filename);
            case 'excel':
                return $this->exportExcel($timesheets, $filename);
            case 'pdf':
                return $this->exportPdf($timesheets, $filename);
            case 'json':
                return $this->exportJson($timesheets, $filename);
            default:
                return $this->exportCsv($timesheets, $filename);
        }
    }

    /**
     * Export timesheets as CSV.
     * 
     * @param \Illuminate\Database\Eloquent\Collection $timesheets
     * @param string $filename Base filename without extension
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    private function exportCsv($timesheets, $filename = 'timesheets')
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
        ];

        $callback = function() use ($timesheets) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, [
                'ID', 'Employee', 'Date', 'Start Time', 'End Time', 
                'Hours Worked', 'Break Duration', 'Tasks Completed', 
                'Notes', 'Status', 'Location', 'Department',
                'Submitted At', 'Updated At'
            ]);
            
            // Add data
            foreach ($timesheets as $timesheet) {
                fputcsv($file, [
                    $timesheet->id,
                    $timesheet->user->name ?? 'Unknown',
                    $timesheet->date->format('Y-m-d'),
                    $timesheet->start_time->format('H:i'),
                    $timesheet->end_time->format('H:i'),
                    $timesheet->hours_worked,
                    $timesheet->break_duration,
                    $timesheet->tasks_completed,
                    $timesheet->notes,
                    $timesheet->status,
                    $timesheet->shift->location ?? 'N/A',
                    $timesheet->user->department ?? 'N/A',
                    $timesheet->created_at->format('Y-m-d H:i:s'),
                    $timesheet->updated_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
    
    /**
     * Export timesheets as JSON.
     * 
     * @param \Illuminate\Database\Eloquent\Collection $timesheets
     * @param string $filename Base filename without extension
     * @return \Illuminate\Http\Response
     */
    private function exportJson($timesheets, $filename = 'timesheets')
    {
        $data = $timesheets->map(function ($timesheet) {
            return [
                'id' => $timesheet->id,
                'employee' => [
                    'id' => $timesheet->user->id,
                    'name' => $timesheet->user->name,
                    'email' => $timesheet->user->email,
                    'department' => $timesheet->user->department,
                ],
                'date' => $timesheet->date->format('Y-m-d'),
                'start_time' => $timesheet->start_time->format('H:i'),
                'end_time' => $timesheet->end_time->format('H:i'),
                'hours_worked' => (float) $timesheet->hours_worked,
                'break_duration' => (float) $timesheet->break_duration,
                'tasks_completed' => $timesheet->tasks_completed,
                'notes' => $timesheet->notes,
                'status' => $timesheet->status,
                'shift' => $timesheet->shift ? [
                    'id' => $timesheet->shift->id,
                    'location' => $timesheet->shift->location,
                ] : null,
                'created_at' => $timesheet->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $timesheet->updated_at->format('Y-m-d H:i:s'),
            ];
        });
        
        return response()->json([
            'count' => $timesheets->count(),
            'data' => $data,
        ])->header('Content-Disposition', 'attachment; filename="' . $filename . '.json"');
    }

    /**
     * Export timesheets as Excel.
     * Note: This requires the maatwebsite/excel package to be installed.
     * 
     * @param \Illuminate\Database\Eloquent\Collection $timesheets
     * @param string $filename Base filename without extension
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    private function exportExcel($timesheets, $filename = 'timesheets')
    {
        // Check if Laravel Excel package is installed
        if (class_exists('\Maatwebsite\Excel\Facades\Excel')) {
            // Implementation would use Laravel Excel package
            // This is a placeholder for the actual implementation
            
            // For now, fallback to CSV with a message
            return response()->streamDownload(function() use ($timesheets) {
                echo "Excel export requires the maatwebsite/excel package.\n";
                echo "Please install it using: composer require maatwebsite/excel\n";
                echo "\nFalling back to CSV format:\n\n";
                
                $file = fopen('php://output', 'w');
                
                // Add headers
                fputcsv($file, [
                    'ID', 'Employee', 'Date', 'Start Time', 'End Time', 
                    'Hours Worked', 'Break Duration', 'Tasks Completed', 
                    'Notes', 'Status', 'Location', 'Department',
                    'Submitted At', 'Updated At'
                ]);
                
                // Add data
                foreach ($timesheets as $timesheet) {
                    fputcsv($file, [
                        $timesheet->id,
                        $timesheet->user->name ?? 'Unknown',
                        $timesheet->date->format('Y-m-d'),
                        $timesheet->start_time->format('H:i'),
                        $timesheet->end_time->format('H:i'),
                        $timesheet->hours_worked,
                        $timesheet->break_duration,
                        $timesheet->tasks_completed,
                        $timesheet->notes,
                        $timesheet->status,
                        $timesheet->shift->location ?? 'N/A',
                        $timesheet->user->department ?? 'N/A',
                        $timesheet->created_at->format('Y-m-d H:i:s'),
                        $timesheet->updated_at->format('Y-m-d H:i:s')
                    ]);
                }
                
                fclose($file);
            }, $filename . '.csv', [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
            ]);
        }
        
        // Fallback to CSV
        return $this->exportCsv($timesheets, $filename);
    }

    /**
     * Export timesheets as PDF.
     * Note: This requires a PDF package like dompdf to be installed.
     * 
     * @param \Illuminate\Database\Eloquent\Collection $timesheets
     * @param string $filename Base filename without extension
     * @return \Illuminate\Http\Response
     */
    private function exportPdf($timesheets, $filename = 'timesheets')
    {
        // Check if dompdf package is installed
        if (class_exists('\Barryvdh\DomPDF\Facade\Pdf') || class_exists('\Barryvdh\DomPDF\PDF')) {
            // Implementation would use dompdf package
            // This is a placeholder for the actual implementation
            
            // For now, return a view that could be used with dompdf
            return response()->streamDownload(function() use ($timesheets) {
                echo "PDF export requires the barryvdh/laravel-dompdf package.\n";
                echo "Please install it using: composer require barryvdh/laravel-dompdf\n";
                echo "\nFalling back to CSV format:\n\n";
                
                $file = fopen('php://output', 'w');
                
                // Add headers
                fputcsv($file, [
                    'ID', 'Employee', 'Date', 'Start Time', 'End Time', 
                    'Hours Worked', 'Break Duration', 'Tasks Completed', 
                    'Notes', 'Status', 'Location', 'Department',
                    'Submitted At', 'Updated At'
                ]);
                
                // Add data
                foreach ($timesheets as $timesheet) {
                    fputcsv($file, [
                        $timesheet->id,
                        $timesheet->user->name ?? 'Unknown',
                        $timesheet->date->format('Y-m-d'),
                        $timesheet->start_time->format('H:i'),
                        $timesheet->end_time->format('H:i'),
                        $timesheet->hours_worked,
                        $timesheet->break_duration,
                        $timesheet->tasks_completed,
                        $timesheet->notes,
                        $timesheet->status,
                        $timesheet->shift->location ?? 'N/A',
                        $timesheet->user->department ?? 'N/A',
                        $timesheet->created_at->format('Y-m-d H:i:s'),
                        $timesheet->updated_at->format('Y-m-d H:i:s')
                    ]);
                }
                
                fclose($file);
            }, $filename . '.csv', [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '.csv"',
            ]);
        }
        
        // Fallback to CSV
        return $this->exportCsv($timesheets, $filename);
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
