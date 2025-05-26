<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $complaints = Auth::user()->complaints()->latest()->paginate(10);
        return view('complaints.index', compact('complaints'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('complaints.create');
    }

    /**
     * Create a complaint from a shift.
     */
    public function createFromShift(Shift $shift)
    {
        return view('complaints.create-from-shift', compact('shift'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'severity' => 'required|in:low,medium,high,critical',
            'shift_id' => 'nullable|exists:shifts,id',
        ]);

        $complaint = new Complaint([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'severity' => $validated['severity'],
            'status' => 'open',
        ]);

        if (isset($validated['shift_id'])) {
            $complaint->shift_id = $validated['shift_id'];
        }

        $complaint->save();

        return redirect()->route('complaints.index')
            ->with('success', 'Complaint submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        $this->authorize('view', $complaint);
        return view('complaints.show', compact('complaint'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        $this->authorize('update', $complaint);
        return view('complaints.edit', compact('complaint'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        $this->authorize('update', $complaint);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'severity' => 'required|in:low,medium,high,critical',
        ]);

        $complaint->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'severity' => $validated['severity'],
        ]);

        return redirect()->route('complaints.index')
            ->with('success', 'Complaint updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        $this->authorize('delete', $complaint);
        
        $complaint->delete();

        return redirect()->route('complaints.index')
            ->with('success', 'Complaint deleted successfully.');
    }

    /**
     * Quick submit a complaint from the shift checkout page.
     */
    public function quickSubmit(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'severity' => 'required|in:low,medium,high,critical',
        ]);

        $complaint = new Complaint([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'severity' => $validated['severity'],
            'status' => 'open',
            'shift_id' => $shift->id,
        ]);

        $complaint->save();

        return redirect()->route('shifts.my')
            ->with('success', 'Your complaint has been submitted successfully. Thank you for your feedback.');
    }
}
