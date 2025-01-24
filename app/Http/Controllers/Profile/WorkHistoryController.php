<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\WorkHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class WorkHistoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $workHistory = Auth::user()->workHistory()->orderBy('start_date', 'desc')->get();
        return view('profile.work-history.index', compact('workHistory'));
    }

    public function create()
    {
        return view('profile.work-history.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'employer_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'responsibilities' => 'required|string',
            'reference_name' => 'required|string|max:255',
            'reference_email' => 'required|email|max:255',
            'reference_phone' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Auth::user()->workHistory()->create($request->all());

        return redirect()->route('profile.work-history.index')
            ->with('success', 'Work history added successfully');
    }

    public function edit(WorkHistory $workHistory)
    {
        $this->authorize('update', $workHistory);
        return view('profile.work-history.edit', compact('workHistory'));
    }

    public function update(Request $request, WorkHistory $workHistory)
    {
        $this->authorize('update', $workHistory);

        $validator = Validator::make($request->all(), [
            'employer_name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'responsibilities' => 'required|string',
            'reference_name' => 'required|string|max:255',
            'reference_email' => 'required|email|max:255',
            'reference_phone' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $workHistory->update($request->all());

        return redirect()->route('profile.work-history.index')
            ->with('success', 'Work history updated successfully');
    }

    public function destroy(WorkHistory $workHistory)
    {
        $this->authorize('delete', $workHistory);
        
        $workHistory->delete();

        return redirect()->route('profile.work-history.index')
            ->with('success', 'Work history deleted successfully');
    }
}
