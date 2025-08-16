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
        
        // Ensure we have fresh data after updates
        $user->refresh();
        
        return view('profile.index', [
            'user' => $user,
            'bankDetails' => $user->bankDetail,
            'workHistory' => $user->workHistory()->latest()->get(),
            'trainingRecords' => $user->trainingRecords()->latest()->get(),
            'profileDetails' => $user->profileDetail
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
            
            Log::info('Profile update started', ['user_id' => auth()->id()]);
            
            $user = auth()->user();
            $validated = $request->validated();

            // Security check - ensure we're updating the authenticated user's profile
            if ($user->id !== auth()->id()) {
                throw new \Exception('Unauthorized profile update attempt');
            }

            Log::info('Profile update validated data:', array_diff_key($validated, array_flip(['profile_photo', 'signature', 'dbs_certificate', 'brp_document'])));

            // Handle file uploads with additional validation
            if ($request->hasFile('profile_photo')) {
                // Additional validation for image files
                $this->validateImageFile($request->file('profile_photo'));
                
                // Delete old file if exists
                if ($user->profile_photo) {
                    Storage::disk('public')->delete($user->profile_photo);
                }
                
                $validated['profile_photo'] = $request->file('profile_photo')
                    ->store('profile-photos', 'public');
                
                Log::info('Profile photo updated', ['user_id' => $user->id]);
            }

            if ($request->hasFile('signature')) {
                // Additional validation for image files
                $this->validateImageFile($request->file('signature'));
                
                // Delete old file if exists
                if ($user->signature) {
                    Storage::disk('public')->delete($user->signature);
                }
                
                $validated['signature'] = $request->file('signature')
                    ->store('signatures', 'public');
                $validated['signature_date'] = now();
                
                Log::info('Signature updated', ['user_id' => $user->id]);
            }

            if ($request->hasFile('dbs_certificate')) {
                // Validate document file
                $this->validateDocumentFile($request->file('dbs_certificate'));
                
                // Delete old file if exists
                if ($user->dbs_certificate) {
                    Storage::disk('public')->delete($user->dbs_certificate);
                }
                
                $validated['dbs_certificate'] = $request->file('dbs_certificate')
                    ->store('dbs-certificates', 'public');
                
                Log::info('DBS certificate updated', ['user_id' => $user->id]);
            }

            if ($request->hasFile('brp_document')) {
                // Validate document file
                $this->validateDocumentFile($request->file('brp_document'));
                
                // Delete old file if exists
                if ($user->brp_document) {
                    Storage::disk('public')->delete($user->brp_document);
                }
                
                $validated['brp_document'] = $request->file('brp_document')
                    ->store('brp-documents', 'public');
                
                Log::info('BRP document updated', ['user_id' => $user->id]);
            }

            // Handle boolean fields
            $validated['has_enhanced_dbs'] = $request->boolean('has_enhanced_dbs');
            $validated['right_to_work_uk'] = $request->boolean('right_to_work_uk');
            $validated['has_criminal_convictions'] = $request->boolean('has_criminal_convictions');

            // Remove address fields from user update as they should only be in ProfileDetail
            $userUpdateData = array_diff_key($validated, array_flip([
                'address_line1', 'address_line2', 'city', 'county', 'postcode'
            ]));
            
            // Update user profile with non-address fields
            $user->update($userUpdateData);
            
            // Update profile details if they exist in the request
            $profileDetailData = [];
            
            // Map form field names to ProfileDetail model field names
            if (isset($validated['address_line1'])) {
                $profileDetailData['address_line_1'] = $validated['address_line1'];
            }
            if (isset($validated['address_line2'])) {
                $profileDetailData['address_line_2'] = $validated['address_line2'];
            }
            if (isset($validated['city'])) {
                $profileDetailData['city'] = $validated['city'];
            }
            if (isset($validated['county'])) {
                $profileDetailData['county'] = $validated['county'];
            }
            if (isset($validated['postcode'])) {
                $profileDetailData['postcode'] = $validated['postcode'];
            }
            
            // Set default country if not provided
            $profileDetailData['country'] = $validated['country'] ?? 'United Kingdom';
            
            if (!empty($profileDetailData)) {
                // Log the profile detail data for debugging
                Log::info('Profile detail data for update:', $profileDetailData);
                
                // Force update by retrieving the profile detail first
                $profileDetail = $user->profileDetail;
                
                if ($profileDetail) {
                    // Update existing profile detail
                    $profileDetail->update($profileDetailData);
                    Log::info('Updated existing profile detail', ['user_id' => $user->id]);
                } else {
                    // Create new profile detail
                    $user->profileDetail()->create($profileDetailData);
                    Log::info('Created new profile detail', ['user_id' => $user->id]);
                }
            }
            
            DB::commit();

            Log::info('Profile updated successfully for user:', ['id' => $user->id]);
            
            // Reload the user with fresh data including relationships
            $user = $user->fresh(['profileDetail']);
            
            // Log the final user data for debugging
            Log::info('Final user data after update:', [
                'user' => $user->only(['id', 'first_name', 'last_name', 'email', 'profile_photo']),
                'profile_detail' => $user->profileDetail ? $user->profileDetail->toArray() : null
            ]);

            // Redirect to profile index page with success message and toast notification
            return redirect()->route('profile.index')
                ->with('success', 'Your profile has been updated successfully.')
                ->with('toast', [
                    'type' => 'success',
                    'message' => 'Profile updated successfully!',
                    'position' => 'top-right'
                ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Profile update failed:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id()
            ]);

            $errorMessage = app()->environment('production') 
                ? 'Failed to update profile. Please try again.' 
                : 'Failed to update profile: ' . $e->getMessage();

            return back()
                ->withInput()
                ->withErrors(['error' => $errorMessage]);
        }
    }
    
    /**
     * Validate image file for security
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @throws \Exception
     */
    private function validateImageFile($file)
    {
        // Check if it's a valid image
        if (!in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/gif'])) {
            throw new \Exception('Invalid image format. Only JPEG, PNG, and GIF are allowed.');
        }
        
        // Check file size (5MB max)
        if ($file->getSize() > 5 * 1024 * 1024) {
            throw new \Exception('Image file size exceeds the 5MB limit.');
        }
    }
    
    /**
     * Validate document file for security
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @throws \Exception
     */
    private function validateDocumentFile($file)
    {
        // Check if it's a valid document type
        $allowedMimes = ['image/jpeg', 'image/png', 'application/pdf'];
        if (!in_array($file->getMimeType(), $allowedMimes)) {
            throw new \Exception('Invalid document format. Only PDF, JPEG, and PNG are allowed.');
        }
        
        // Check file size (5MB max)
        if ($file->getSize() > 5 * 1024 * 1024) {
            throw new \Exception('Document file size exceeds the 5MB limit.');
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