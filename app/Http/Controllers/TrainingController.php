<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $trainings = Training::where('user_id', auth()->id())->paginate(10);
        return view('trainings.index', compact('trainings'));
    }
}
