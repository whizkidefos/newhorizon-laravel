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
        $workHistories = WorkHistory::where('user_id', auth()->id())->paginate(10);
        return view('work-histories.index', compact('workHistories'));
    }
}
