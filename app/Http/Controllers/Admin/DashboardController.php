<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Shift;
use App\Models\Activity;
use App\Models\Document;
use App\Models\Timesheet;
use App\Models\Complaint;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // User statistics
        $totalUsers = User::where('is_admin', false)->count();
        $newUsersThisMonth = User::where('is_admin', false)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();
        $verifiedUsers = User::where('is_admin', false)
            ->whereNotNull('email_verified_at')
            ->count();
        $unverifiedUsers = $totalUsers - $verifiedUsers;

        // Document statistics
        $totalDocuments = Document::count();
        $pendingDocuments = Document::where('verified', false)->count();
        $verifiedDocuments = $totalDocuments - $pendingDocuments;

        // Shift statistics
        $upcomingShifts = Shift::where('start_time', '>', now())
            ->where('start_time', '<', now()->addDays(7))
            ->count();
        
        // Timesheet statistics
        $totalTimesheets = Timesheet::count();
        $pendingTimesheets = Timesheet::where('status', 'pending')->count();
        $approvedTimesheets = Timesheet::where('status', 'approved')->count();
        $rejectedTimesheets = Timesheet::where('status', 'rejected')->count();
        
        // Complaint statistics
        $totalComplaints = Complaint::count();
        $openComplaints = Complaint::where('status', 'open')->count();
        $inProgressComplaints = Complaint::where('status', 'in_progress')->count();
        $resolvedComplaints = Complaint::where('status', 'resolved')->count();
        $closedComplaints = Complaint::where('status', 'closed')->count();
        
        // Monthly user registration trend
        $userTrend = User::where('is_admin', false)
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->select(DB::raw("strftime('%Y-%m', created_at) as month"), DB::raw('count(*) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Document types distribution
        $documentTypes = Document::select('type', DB::raw('count(*) as total'))
            ->groupBy('type')
            ->orderByDesc('total')
            ->get();

        // Recent activities
        $recentActivities = Activity::with('user')
            ->latest()
            ->take(10)
            ->get();

        // Users needing attention (missing critical documents or unverified)
        $usersNeedingAttention = User::where('is_admin', false)
            ->where(function($query) {
                $query->whereNull('email_verified_at')
                    ->orWhereDoesntHave('documents', function($q) {
                        $q->where('type', 'Right to Work')
                            ->where('verified', true);
                    });
            })
            ->with(['documents' => function($query) {
                $query->where('type', 'Right to Work');
            }])
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'newUsersThisMonth',
            'verifiedUsers',
            'unverifiedUsers',
            'totalDocuments',
            'pendingDocuments',
            'verifiedDocuments',
            'upcomingShifts',
            'totalTimesheets',
            'pendingTimesheets',
            'approvedTimesheets',
            'rejectedTimesheets',
            'totalComplaints',
            'openComplaints',
            'inProgressComplaints',
            'resolvedComplaints',
            'closedComplaints',
            'userTrend',
            'documentTypes',
            'recentActivities',
            'usersNeedingAttention'
        ));
    }
}