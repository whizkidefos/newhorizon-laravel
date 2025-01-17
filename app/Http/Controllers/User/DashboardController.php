<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $upcomingShifts = $user->shifts()
            ->where('start_datetime', '>', now())
            ->orderBy('start_datetime')
            ->take(5)
            ->get();
            
        $completedShifts = $user->shifts()
            ->where('status', 'completed')
            ->orderBy('end_datetime', 'desc')
            ->take(5)
            ->get();
            
        $availableCourses = Course::where('status', 'active')
            ->whereNotIn('id', $user->courses->pluck('id'))
            ->take(5)
            ->get();
            
        return view('user.dashboard', compact(
            'upcomingShifts',
            'completedShifts',
            'availableCourses'
        ));
    }
}