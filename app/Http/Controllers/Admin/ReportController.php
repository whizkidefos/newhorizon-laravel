<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\ShiftReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index', [
            'stats' => $this->getOverallStats(),
            'recentShifts' => $this->getRecentShifts(),
            'topLocations' => $this->getTopLocations(),
            'staffPerformance' => $this->getStaffPerformance(),
        ]);
    }

    public function export(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'type' => 'required|in:shifts,staff,locations'
        ]);

        return Excel::download(
            new ShiftReportExport($validated),
            'shift-report-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    private function getOverallStats()
    {
        $currentMonth = now()->startOfMonth();
        
        return [
            'total_shifts' => Shift::whereMonth('start_datetime', $currentMonth)->count(),
            'completed_shifts' => Shift::whereMonth('start_datetime', $currentMonth)
                ->where('status', 'completed')
                ->count(),
            'cancelled_shifts' => Shift::whereMonth('start_datetime', $currentMonth)
                ->where('status', 'cancelled')
                ->count(),
            'total_hours' => Shift::whereMonth('start_datetime', $currentMonth)
                ->where('status', 'completed')
                ->sum(\DB::raw('TIMESTAMPDIFF(HOUR, start_datetime, end_datetime)')),
        ];
    }

    private function getRecentShifts()
    {
        return Shift::with('user')
            ->latest('start_datetime')
            ->take(10)
            ->get();
    }

    private function getTopLocations()
    {
        return Shift::select('location', \DB::raw('count(*) as total'))
            ->where('status', 'completed')
            ->groupBy('location')
            ->orderByDesc('total')
            ->take(5)
            ->get();
    }

    private function getStaffPerformance()
    {
        return User::whereHas('shifts', function($query) {
                $query->where('status', 'completed');
            })
            ->withCount(['shifts as completed_shifts' => function($query) {
                $query->where('status', 'completed');
            }])
            ->withCount(['shifts as cancelled_shifts' => function($query) {
                $query->where('status', 'cancelled');
            }])
            ->orderByDesc('completed_shifts')
            ->take(10)
            ->get();
    }
}