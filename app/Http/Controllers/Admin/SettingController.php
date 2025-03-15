<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Show the form for editing the application settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        // In a real application, you would load settings from the database
        // For now, we'll just return a view
        return view('admin.settings.edit');
    }

    /**
     * Update the application settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_email' => 'nullable|email|max:255',
            'company_phone' => 'nullable|string|max:20',
            'company_address' => 'nullable|string|max:500',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'site_title' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'footer_text' => 'nullable|string|max:500',
        ]);

        // In a real application, you would save these settings to the database
        // For now, we'll just redirect back with a success message

        // Handle logo upload if provided
        if ($request->hasFile('company_logo')) {
            // Store the new logo
            $path = $request->file('company_logo')->store('logos', 'public');
            // You would save this path to the database in a real application
        }

        return redirect()->route('admin.settings.edit')
            ->with('success', 'Settings updated successfully.');
    }
}
