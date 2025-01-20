<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'total_users' => \App\Models\User::count(),
                'active_shifts' => \App\Models\Shift::where('status', 'active')->count(),
                'total_courses' => \App\Models\Course::count(),
            ]
        ]);
    }
}