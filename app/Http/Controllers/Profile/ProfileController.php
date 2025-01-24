<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\ProfileDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $user = Auth::user()->load('profileDetail');
        return view('profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user()->load('profileDetail');
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'mobile_number' => 'required|string|max:255|unique:users,mobile_number,' . $user->id,
            'job_role' => 'required|in:Registered Nurse,Healthcare Assistant,Support Worker',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
            'profile_photo' => 'nullable|image|max:2048',
            'national_insurance_number' => 'required|string|max:255|unique:users,national_insurance_number,' . $user->id,
            'has_enhanced_dbs' => 'required|boolean',
            'dbs_certificate' => 'required_if:has_enhanced_dbs,true|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'nationality' => 'required|in:UK,EU,Other',
            'right_to_work_uk' => 'required|boolean',
            'brp_number' => 'required_if:nationality,Other|string|max:255',
            'brp_document' => 'required_if:nationality,Other|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'has_criminal_convictions' => 'required|boolean',
            'postcode' => 'required|string|max:255',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'county' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'combined_certificate' => 'nullable|file|mimes:pdf|max:2048',
            'consent' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update user details
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'mobile_number' => $request->mobile_number,
            'job_role' => $request->job_role,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'national_insurance_number' => $request->national_insurance_number,
            'has_enhanced_dbs' => $request->has_enhanced_dbs,
            'nationality' => $request->nationality,
            'right_to_work_uk' => $request->right_to_work_uk,
            'brp_number' => $request->brp_number,
            'has_criminal_convictions' => $request->has_criminal_convictions,
        ]);

        // Handle file uploads
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo = $path;
            $user->save();
        }

        if ($request->hasFile('dbs_certificate')) {
            $path = $request->file('dbs_certificate')->store('dbs-certificates', 'public');
            $user->dbs_certificate = $path;
            $user->save();
        }

        if ($request->hasFile('brp_document')) {
            $path = $request->file('brp_document')->store('brp-documents', 'public');
            $user->brp_document = $path;
            $user->save();
        }

        // Update or create profile details
        $profileData = [
            'postcode' => $request->postcode,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'county' => $request->county,
            'country' => $request->country,
            'consent_given' => true,
        ];

        if ($request->hasFile('cv')) {
            $profileData['cv_path'] = $request->file('cv')->store('cvs', 'public');
        }

        if ($request->hasFile('combined_certificate')) {
            $profileData['combined_certificate_path'] = $request->file('combined_certificate')->store('certificates', 'public');
        }

        $user->profileDetail()->updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        return redirect()->route('profile.index')
            ->with('success', 'Profile updated successfully');
    }

    public function uploadSignature(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'signature' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();
        $image = $request->signature;
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = 'signature-' . $user->id . '.png';
        
        Storage::disk('public')->put('signatures/' . $imageName, base64_decode($image));

        $user->update([
            'signature' => 'signatures/' . $imageName,
            'signature_date' => now(),
        ]);

        return response()->json(['message' => 'Signature uploaded successfully']);
    }
}
