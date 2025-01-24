<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\TrainingRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $trainings = Auth::user()->trainingRecords()
            ->orderBy('completion_date', 'desc')
            ->get()
            ->groupBy('type');
        return view('profile.training.index', compact('trainings'));
    }

    public function create()
    {
        return view('profile.training.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'training_name' => 'required|string|max:255',
            'type' => 'required|in:COSHH,Conflict Resolution,Domestic Violence and Abuse,Epilepsy Awareness,Other',
            'passed' => 'required|boolean',
            'completion_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:completion_date',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $trainingData = $request->except('certificate');

        if ($request->hasFile('certificate')) {
            $trainingData['certificate_path'] = $request->file('certificate')
                ->store('training-certificates', 'public');
        }

        Auth::user()->trainingRecords()->create($trainingData);

        return redirect()->route('profile.training.index')
            ->with('success', 'Training record added successfully');
    }

    public function edit(TrainingRecord $training)
    {
        $this->authorize('update', $training);
        return view('profile.training.edit', compact('training'));
    }

    public function update(Request $request, TrainingRecord $training)
    {
        $this->authorize('update', $training);

        $validator = Validator::make($request->all(), [
            'training_name' => 'required|string|max:255',
            'type' => 'required|in:COSHH,Conflict Resolution,Domestic Violence and Abuse,Epilepsy Awareness,Other',
            'passed' => 'required|boolean',
            'completion_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:completion_date',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $trainingData = $request->except('certificate');

        if ($request->hasFile('certificate')) {
            // Delete old certificate if exists
            if ($training->certificate_path) {
                Storage::disk('public')->delete($training->certificate_path);
            }
            
            $trainingData['certificate_path'] = $request->file('certificate')
                ->store('training-certificates', 'public');
        }

        $training->update($trainingData);

        return redirect()->route('profile.training.index')
            ->with('success', 'Training record updated successfully');
    }

    public function destroy(TrainingRecord $training)
    {
        $this->authorize('delete', $training);

        if ($training->certificate_path) {
            Storage::disk('public')->delete($training->certificate_path);
        }
        
        $training->delete();

        return redirect()->route('profile.training.index')
            ->with('success', 'Training record deleted successfully');
    }
}
