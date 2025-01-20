<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Shift;
use App\Models\Course;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $stats = [
            'totalUsers' => User::where('is_admin', false)->count(),
            'activeShifts' => Shift::where('status', 'active')->count(),
            'pendingVerifications' => User::whereNull('email_verified_at')
                ->orWhereNull('phone_verified_at')
                ->count(),
            'totalRevenue' => Course::join('course_user', 'courses.id', '=', 'course_user.course_id')
                ->where('payment_status', 'completed')
                ->sum('price'),
        ];

        // Get recent activities
        $recentActivities = Activity::with('causer')
            ->latest()
            ->take(10)
            ->get();

        // Get users currently on shift
        $activeUsers = User::whereHas('shifts', function($query) {
            $query->where('status', 'checked_in');
        })->with(['currentShift' => function($query) {
            $query->select('id', 'user_id', 'location', 'start_datetime', 'last_tracked_location');
        }])->get();

        // Get weekly stats for chart
        $weeklyStats = $this->getWeeklyStats();

        return view('admin.dashboard', compact(
            'stats',
            'recentActivities',
            'activeUsers',
            'weeklyStats'
        ));
    }

    private function getWeeklyStats()
    {
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $dailyShifts = Shift::whereBetween('start_datetime', [$startOfWeek, $endOfWeek])
            ->select(
                DB::raw('DATE(start_datetime) as date'),
                DB::raw('COUNT(*) as total_shifts'),
                DB::raw('COUNT(CASE WHEN status = "completed" THEN 1 END) as completed_shifts')
            )
            ->groupBy('date')
            ->get();

        $stats = [];
        for ($date = $startOfWeek->copy(); $date <= $endOfWeek; $date->addDay()) {
            $dayStats = $dailyShifts->firstWhere('date', $date->format('Y-m-d'));
            $stats[] = [
                'date' => $date->format('D'),
                'total_shifts' => $dayStats->total_shifts ?? 0,
                'completed_shifts' => $dayStats->completed_shifts ?? 0,
            ];
        }

        return $stats;
    }
}