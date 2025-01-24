<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BankDetailsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $bankDetails = Auth::user()->bankDetail;
        return view('profile.bank-details', compact('bankDetails'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bank_name' => 'required|string|max:255',
            'sort_code' => 'required|string|size:6',
            'account_number' => 'required|string|size:8',
            'account_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Auth::user()->bankDetail()->updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'bank_name' => $request->bank_name,
                'sort_code' => $request->sort_code,
                'account_number' => $request->account_number,
                'account_name' => $request->account_name,
            ]
        );

        return redirect()->route('profile.bank-details.index')
            ->with('success', 'Bank details updated successfully');
    }

    public function update(Request $request)
    {
        return $this->store($request);
    }
}
