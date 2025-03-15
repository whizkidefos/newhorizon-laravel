<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('profile.index', [
            'user' => $user,
            'bankDetails' => $user->bankDetails,
            'workHistory' => $user->workHistory()->latest()->get(),
            'trainingRecords' => $user->trainingRecords()->latest()->get(),
            'profileDetails' => $user->profileDetails
        ]);
    }

    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user()
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $user = auth()->user();
            $validated = $request->validated();

            Log::info('Profile update validated data:', $validated);

            // Handle file uploads
            if ($request->hasFile('profile_photo')) {
                if ($user->profile_photo) {
                    Storage::disk('public')->delete($user->profile_photo);
                }
                $validated['profile_photo'] = $request->file('profile_photo')
                    ->store('profile-photos', 'public');
            }

            if ($request->hasFile('signature')) {
                if ($user->signature) {
                    Storage::disk('public')->delete($user->signature);
                }
                $validated['signature'] = $request->file('signature')
                    ->store('signatures', 'public');
                $validated['signature_date'] = now();
            }

            if ($request->hasFile('dbs_certificate')) {
                if ($user->dbs_certificate) {
                    Storage::disk('public')->delete($user->dbs_certificate);
                }
                $validated['dbs_certificate'] = $request->file('dbs_certificate')
                    ->store('dbs-certificates', 'public');
            }

            if ($request->hasFile('brp_document')) {
                if ($user->brp_document) {
                    Storage::disk('public')->delete($user->brp_document);
                }
                $validated['brp_document'] = $request->file('brp_document')
                    ->store('brp-documents', 'public');
            }

            // Handle boolean fields
            $validated['has_enhanced_dbs'] = $request->boolean('has_enhanced_dbs');
            $validated['right_to_work_uk'] = $request->boolean('right_to_work_uk');
            $validated['has_criminal_convictions'] = $request->boolean('has_criminal_convictions');

            // Ensure employment details are properly handled
            $validated['employee_id'] = $request->input('employee_id');
            $validated['department'] = $request->input('department');
            $validated['position'] = $request->input('position');

            // Ensure address fields are properly handled
            $validated['address_line_1'] = $request->input('address_line_1');
            $validated['address_line_2'] = $request->input('address_line_2');
            $validated['city'] = $request->input('city');
            $validated['county'] = $request->input('county');
            $validated['postcode'] = $request->input('postcode');

            // Update user profile
            $user->update($validated);
            
            DB::commit();

            Log::info('Profile updated successfully for user:', ['id' => $user->id, 'data' => $validated]);

            // Redirect to profile index page with success message
            return redirect()->route('profile.index')
                ->with('success', 'Your profile has been updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Profile update failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->withErrors(['error' => 'Failed to update profile: ' . $e->getMessage()]);
        }
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        auth()->user()->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Password updated successfully');
    }
}