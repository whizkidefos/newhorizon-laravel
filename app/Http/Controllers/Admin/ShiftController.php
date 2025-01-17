<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Services\PDF\ShiftPdfGenerator;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index(Request $request)
    {
        $shifts = Shift::query()
            ->when($request->filled('date_filter'), function($query) use ($request) {
                // Apply date filters
            })
            ->when($request->filled('status'), function($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->paginate(15);

        return view('admin.shifts.index', compact('shifts'));
    }

    public function exportPdf(Request $request, ShiftPdfGenerator $pdfGenerator)
    {
        $shifts = Shift::query()
            // Apply filters
            ->get();

        return $pdfGenerator->generate($shifts);
    }

    public function assign(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'shift_ids' => 'required|array',
            'shift_ids.*' => 'exists:shifts,id'
        ]);

        Shift::whereIn('id', $validated['shift_ids'])
            ->update(['user_id' => $validated['user_id']]);

        return response()->json(['message' => 'Shifts assigned successfully']);
    }
}