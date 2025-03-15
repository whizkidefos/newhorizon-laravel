<?php

namespace App\Http\Controllers;

use App\Models\BankDetail;
use Illuminate\Http\Request;

class BankDetailsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $bankDetails = BankDetail::where('user_id', auth()->id())->first();
        return view('profile.bank-details', compact('bankDetails'));
    }

    /**
     * Store a newly created bank details in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|size:8',
            'sort_code' => 'required|string|max:8',
        ]);

        // Add user_id to the validated data
        $validated['user_id'] = auth()->id();

        // Create the bank details
        BankDetail::create($validated);

        return redirect()->route('profile.bank-details')
            ->with('success', 'Bank details added successfully.');
    }

    /**
     * Update the specified bank details in storage.
     */
    public function update(Request $request, BankDetail $bankDetail)
    {
        // Ensure the bank detail belongs to the authenticated user
        if ($bankDetail->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|size:8',
            'sort_code' => 'required|string|max:8',
        ]);

        // Update the bank details
        $bankDetail->update($validated);

        return redirect()->route('profile.bank-details')
            ->with('success', 'Bank details updated successfully.');
    }
}
