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
        return view('bank-details.index', compact('bankDetails'));
    }
}
