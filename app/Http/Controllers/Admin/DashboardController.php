<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Shift;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'active_shifts' => Shift::where('status', 'active')->count(),
            'completed_shifts' => Shift::where('status', 'completed')->count(),
            'recent_logins' => User::orderBy('last_login_at', 'desc')
                                  ->take(10)
                                  ->get(),
            'checked_in_users' => User::whereHas('shifts', function($query) {
                $query->where('status', 'checked_in');
            })->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}