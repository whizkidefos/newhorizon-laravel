<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Support\Facades\Storage;

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
        $user = auth()->user();
        $validated = $request->validated();

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

        $user->update($validated);

        if ($request->has('address_line_1')) {
            $user->profileDetails()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'address_line_1' => $request->address_line_1,
                    'address_line_2' => $request->address_line_2,
                    'city' => $request->city,
                    'postcode' => $request->postcode,
                    'country' => $request->country,
                ]
            );
        }

        return redirect()->route('profile.index')
            ->with('success', 'Profile updated successfully');
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