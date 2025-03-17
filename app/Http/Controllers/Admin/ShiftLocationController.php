<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShiftLocation;
use Illuminate\Http\Request;

class ShiftLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = ShiftLocation::latest()->paginate(10);
        return view('admin.shift-locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.shift-locations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        ShiftLocation::create($validated);

        return redirect()->route('admin.shift-locations.index')
            ->with('success', 'Shift location created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShiftLocation $shiftLocation)
    {
        return view('admin.shift-locations.show', compact('shiftLocation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShiftLocation $shiftLocation)
    {
        return view('admin.shift-locations.edit', compact('shiftLocation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShiftLocation $shiftLocation)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ]);

        $shiftLocation->update($validated);

        return redirect()->route('admin.shift-locations.index')
            ->with('success', 'Shift location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShiftLocation $shiftLocation)
    {
        // Check if the location is being used by any shifts
        if ($shiftLocation->shifts()->count() > 0) {
            return back()->with('error', 'Cannot delete location that is being used by shifts.');
        }

        $shiftLocation->delete();

        return redirect()->route('admin.shift-locations.index')
            ->with('success', 'Shift location deleted successfully.');
    }
}
