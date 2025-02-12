<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Shift;
use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Prepare stats array
        $stats = [];

        // Get healthcare workers count
        $stats['total_users'] = User::role('healthcare_worker')->count();
        $stats['new_users_this_month'] = User::role('healthcare_worker')
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        // Get shift statistics
        $stats['active_shifts'] = Shift::where('status', 'in_progress')->count();
        $stats['upcoming_shifts'] = Shift::where('status', 'scheduled')
            ->where('start_datetime', '>', Carbon::now())
            ->count();

        // Get course statistics
        $stats['total_courses'] = Course::count();
        $stats['total_enrollments'] = DB::table('course_user')->count();
        $stats['active_enrollments'] = DB::table('course_user')
            ->where('status', 'in_progress')
            ->count();

        // Calculate revenue using SQLite compatible date functions
        $stats['monthly_revenue'] = Shift::whereRaw("strftime('%m', start_datetime) = ?", [Carbon::now()->format('m')])
            ->whereRaw("strftime('%Y', start_datetime) = ?", [Carbon::now()->format('Y')])
            ->where('status', 'completed')
            ->sum(DB::raw('rate_per_hour * round((julianday(end_datetime) - julianday(start_datetime)) * 24)'));

        $lastMonthRevenue = Shift::whereRaw("strftime('%m', start_datetime) = ?", [Carbon::now()->subMonth()->format('m')])
            ->whereRaw("strftime('%Y', start_datetime) = ?", [Carbon::now()->subMonth()->format('Y')])
            ->where('status', 'completed')
            ->sum(DB::raw('rate_per_hour * round((julianday(end_datetime) - julianday(start_datetime)) * 24)'));

        $stats['revenue_change'] = $lastMonthRevenue > 0 
            ? round((($stats['monthly_revenue'] - $lastMonthRevenue) / $lastMonthRevenue) * 100, 1)
            : 100;

        // Get recent shifts
        $stats['recent_shifts'] = Shift::with('user')
            ->orderBy('start_datetime', 'desc')
            ->take(5)
            ->get();

        // Get popular courses
        $stats['popular_courses'] = Course::withCount('users')
            ->orderBy('users_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats'));
    }
}