<?php

namespace App\Http\Controllers;

use App\Models\WorkHistory;
use Illuminate\Http\Request;

class WorkHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $workHistory = auth()->user()->workHistory()->latest()->get();
        return view('profile.work-history', compact('workHistory'));
    }
}
