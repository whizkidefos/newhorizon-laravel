<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;
use App\Exports\TimesheetExport;
use Maatwebsite\Excel\Facades\Excel;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = auth()->user()->shifts()->latest()->paginate(10);
        return view('shifts.index', compact('shifts'));
    }

    public function available()
    {
        $shifts = Shift::available()->latest()->paginate(10);
        return view('shifts.available', compact('shifts'));
    }

    public function pickup(Shift $shift)
    {
        if ($shift->isAvailable()) {
            $shift->update(['user_id' => auth()->id(), 'status' => 'assigned']);
            return redirect()->route('shifts.index')->with('success', 'Shift picked up successfully.');
        }
        return back()->with('error', 'Shift is no longer available.');
    }

    public function checkin(Shift $shift)
    {
        if ($shift->user_id === auth()->id() && $shift->status === 'assigned') {
            $shift->update([
                'status' => 'in_progress',
                'checked_in_at' => now()
            ]);
            return back()->with('success', 'Checked in successfully.');
        }
        return back()->with('error', 'Unable to check in for this shift.');
    }

    public function checkout(Shift $shift)
    {
        if ($shift->user_id === auth()->id() && $shift->status === 'in_progress') {
            $shift->update([
                'status' => 'completed',
                'checked_out_at' => now()
            ]);
            return back()->with('success', 'Checked out successfully.');
        }
        return back()->with('error', 'Unable to check out from this shift.');
    }

    public function timesheets()
    {
        $timesheets = auth()->user()->shifts()
            ->whereIn('status', ['completed', 'approved'])
            ->latest()
            ->paginate(10);
        return view('shifts.timesheets', compact('timesheets'));
    }

    public function submitTimesheet(Request $request)
    {
        $validated = $request->validate([
            'shift_ids' => 'required|array',
            'shift_ids.*' => 'exists:shifts,id',
            'notes' => 'nullable|string'
        ]);

        $shifts = Shift::whereIn('id', $validated['shift_ids'])
            ->where('user_id', auth()->id())
            ->where('status', 'completed')
            ->update([
                'status' => 'pending_approval',
                'timesheet_notes' => $validated['notes'] ?? null
            ]);

        return back()->with('success', 'Timesheet submitted for approval.');
    }

    public function exportTimesheets(Request $request)
    {
        $format = $request->input('format', 'xlsx');
        $filename = 'timesheets_' . now()->format('Y_m_d') . '.' . $format;
        
        return Excel::download(new TimesheetExport(auth()->user()), $filename);
    }
}
