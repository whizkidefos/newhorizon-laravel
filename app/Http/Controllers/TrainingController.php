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
        $trainings = auth()->user()->trainingRecords()->latest()->get();
        return view('profile.trainings', compact('trainings'));
    }
}
