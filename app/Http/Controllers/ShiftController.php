<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use App\Models\Timesheet;
use Illuminate\Http\Request;
use App\Exports\TimesheetExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

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
            
            // Redirect to a page that offers timesheet submission and complaint options
            return redirect()->route('shifts.checkout-options', $shift)
                ->with('success', 'Checked out successfully. Would you like to submit a timesheet or report any issues?');
        }
        return back()->with('error', 'Unable to check out from this shift.');
    }

    /**
     * Show options after checkout (submit timesheet or complaint)
     */
    public function checkoutOptions(Shift $shift)
    {
        // Ensure the shift belongs to the authenticated user and is completed
        if ($shift->user_id !== Auth::id() || $shift->status !== 'completed') {
            return redirect()->route('shifts.my')->with('error', 'Invalid shift access.');
        }

        return view('shifts.checkout-options', compact('shift'));
    }

    /**
     * Quick submit timesheet from shift checkout
     */
    public function quickSubmitTimesheet(Request $request, Shift $shift)
    {
        // Ensure the shift belongs to the authenticated user and is completed
        if ($shift->user_id !== Auth::id() || $shift->status !== 'completed') {
            return redirect()->route('shifts.my')->with('error', 'Invalid shift access.');
        }

        $validated = $request->validate([
            'tasks_completed' => 'nullable|string',
            'notes' => 'nullable|string',
            'break_duration' => 'required|numeric|min:0',
        ]);

        // Calculate hours worked
        $startTime = Carbon::parse($shift->checked_in_at);
        $endTime = Carbon::parse($shift->checked_out_at);
        $hoursWorked = $endTime->diffInMinutes($startTime) / 60;
        
        // Subtract break duration
        $hoursWorked -= $validated['break_duration'];

        // Create timesheet
        $timesheet = new Timesheet([
            'user_id' => Auth::id(),
            'shift_id' => $shift->id,
            'date' => $shift->date,
            'start_time' => $shift->checked_in_at,
            'end_time' => $shift->checked_out_at,
            'hours_worked' => $hoursWorked,
            'break_duration' => $validated['break_duration'],
            'tasks_completed' => $validated['tasks_completed'],
            'notes' => $validated['notes'],
            'status' => 'pending',
        ]);

        $timesheet->save();

        return redirect()->route('shifts.my')
            ->with('success', 'Timesheet submitted successfully and is pending approval.');
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

    /**
     * Display a listing of the authenticated user's shifts.
     */
    public function myShifts()
    {
        $user = auth()->user();
        $shifts = $user->shifts()->with(['facility'])->latest()->paginate(10);

        return view('shifts.my-shifts', compact('shifts'));
    }
}
