<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Complaint::with(['user', 'shift', 'resolver']);

        // Filter by user
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by severity
        if ($request->has('severity') && $request->severity) {
            $query->where('severity', $request->severity);
        }

        // Filter by date
        if ($request->has('date') && $request->date) {
            $query->whereDate('created_at', $request->date);
        }

        // Filter by date range
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $complaints = $query->latest()->paginate(15);
        $users = User::orderBy('first_name')->get();

        return view('admin.complaints.index', compact('complaints', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::orderBy('first_name')->get();
        return view('admin.complaints.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'severity' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:open,in_progress,resolved,closed',
            'resolution_notes' => 'nullable|required_if:status,resolved,closed|string',
            'shift_id' => 'nullable|exists:shifts,id',
        ]);

        $complaint = new Complaint([
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'severity' => $validated['severity'],
            'status' => $validated['status'],
            'resolution_notes' => $validated['resolution_notes'] ?? null,
            'shift_id' => $validated['shift_id'] ?? null,
        ]);

        if (in_array($validated['status'], ['resolved', 'closed'])) {
            $complaint->resolved_by = Auth::id();
            $complaint->resolved_at = Carbon::now();
        }

        $complaint->save();

        return redirect()->route('admin.complaints.index')
            ->with('success', 'Complaint created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        return view('admin.complaints.show', compact('complaint'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        $users = User::orderBy('first_name')->get();
        return view('admin.complaints.edit', compact('complaint', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'severity' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:open,in_progress,resolved,closed',
            'resolution_notes' => 'nullable|required_if:status,resolved,closed|string',
        ]);

        $data = [
            'user_id' => $validated['user_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'severity' => $validated['severity'],
            'status' => $validated['status'],
            'resolution_notes' => $validated['resolution_notes'] ?? null,
        ];

        // If status changed to resolved or closed
        if (in_array($validated['status'], ['resolved', 'closed']) && 
            !in_array($complaint->status, ['resolved', 'closed'])) {
            $data['resolved_by'] = Auth::id();
            $data['resolved_at'] = Carbon::now();
        }

        // If status changed from resolved/closed to something else
        if (!in_array($validated['status'], ['resolved', 'closed']) && 
            in_array($complaint->status, ['resolved', 'closed'])) {
            $data['resolved_by'] = null;
            $data['resolved_at'] = null;
        }

        $complaint->update($data);

        return redirect()->route('admin.complaints.index')
            ->with('success', 'Complaint updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        $complaint->delete();

        return redirect()->route('admin.complaints.index')
            ->with('success', 'Complaint deleted successfully.');
    }

    /**
     * Mark a complaint as in progress.
     */
    public function markInProgress(Complaint $complaint)
    {
        $complaint->update([
            'status' => 'in_progress',
        ]);

        return redirect()->back()->with('success', 'Complaint marked as in progress.');
    }

    /**
     * Resolve a complaint.
     */
    public function resolve(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'resolution_notes' => 'required|string',
        ]);

        $complaint->update([
            'status' => 'resolved',
            'resolution_notes' => $validated['resolution_notes'],
            'resolved_by' => Auth::id(),
            'resolved_at' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Complaint resolved successfully.');
    }

    /**
     * Close a complaint.
     */
    public function close(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'resolution_notes' => 'required|string',
        ]);

        $complaint->update([
            'status' => 'closed',
            'resolution_notes' => $validated['resolution_notes'],
            'resolved_by' => Auth::id(),
            'resolved_at' => Carbon::now(),
        ]);

        return redirect()->back()->with('success', 'Complaint closed successfully.');
    }

    /**
     * Export complaints based on filters.
     */
    public function export(Request $request)
    {
        $query = Complaint::with(['user', 'shift', 'resolver']);

        // Apply filters
        if ($request->has('user_id') && $request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('severity') && $request->severity) {
            $query->where('severity', $request->severity);
        }

        if ($request->has('date') && $request->date) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $complaints = $query->get();
        
        // Create CSV
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="complaints.csv"',
        ];

        $callback = function() use ($complaints) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, [
                'ID', 'Employee', 'Title', 'Description', 'Severity', 
                'Status', 'Resolution Notes', 'Resolved By', 'Resolved At', 'Submitted At'
            ]);
            
            // Add data
            foreach ($complaints as $complaint) {
                fputcsv($file, [
                    $complaint->id,
                    $complaint->user->full_name,
                    $complaint->title,
                    $complaint->description,
                    $complaint->severity,
                    $complaint->status,
                    $complaint->resolution_notes,
                    $complaint->resolver ? $complaint->resolver->full_name : '',
                    $complaint->resolved_at ? $complaint->resolved_at->format('Y-m-d H:i:s') : '',
                    $complaint->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
