<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ContentManagementController extends Controller
{
    /**
     * Display the content management dashboard.
     */
    public function index()
    {
        try {
            $generalSettings = SiteSetting::where('group', 'general')->get();
            $appearanceSettings = SiteSetting::where('group', 'appearance')->get();
            $seoSettings = SiteSetting::where('group', 'seo')->get();
            
            return view('admin.content-management.index', compact(
                'generalSettings', 
                'appearanceSettings', 
                'seoSettings'
            ));
        } catch (\Exception $e) {
            // Check if the exception is related to missing table
            if (str_contains($e->getMessage(), 'no such table') || str_contains($e->getMessage(), "doesn't exist")) {
                // Run the migration for site_settings table
                \Illuminate\Support\Facades\Artisan::call('migrate', [
                    '--path' => 'database/migrations/2025_08_16_000000_create_site_settings_table.php',
                    '--force' => true,
                ]);
                
                // Seed the table with initial data
                \Illuminate\Support\Facades\Artisan::call('db:seed', [
                    '--class' => 'SiteSettingSeeder',
                    '--force' => true,
                ]);
                
                // Now try to get the data again
                $generalSettings = SiteSetting::where('group', 'general')->get();
                $appearanceSettings = SiteSetting::where('group', 'appearance')->get();
                $seoSettings = SiteSetting::where('group', 'seo')->get();
                
                return view('admin.content-management.index', compact(
                    'generalSettings', 
                    'appearanceSettings', 
                    'seoSettings'
                ))->with('success', 'Content management system has been initialized.');
            }
            
            // For other exceptions, rethrow
            throw $e;
        }
    }
    
    /**
     * Display the logo management page.
     */
    public function logoManagement()
    {
        try {
            $logo = SiteSetting::get('site_logo');
            $logoAlt = SiteSetting::get('site_logo_alt');
            
            return view('admin.content-management.logo', compact('logo', 'logoAlt'));
        } catch (\Exception $e) {
            return redirect()->route('admin.content.index');
        }
    }
    
    /**
     * Update the site logo.
     */
    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            $oldLogo = SiteSetting::get('site_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }
            
            // Store new logo
            $path = $request->file('logo')->store('logos', 'public');
            SiteSetting::set('site_logo', $path);
            SiteSetting::set('site_logo_alt', $request->input('logo_alt', 'New Horizon Healthcare Services'));
            
            return redirect()->route('admin.content.logo')
                ->with('success', 'Logo updated successfully.');
        }
        
        // Update alt text even if no new logo is uploaded
        if ($request->has('logo_alt')) {
            SiteSetting::set('site_logo_alt', $request->input('logo_alt'));
            return redirect()->route('admin.content.logo')
                ->with('success', 'Logo alt text updated successfully.');
        }
        
        return redirect()->route('admin.content.logo')
            ->with('info', 'No changes were made.');
    }
    
    /**
     * Display the favicon management page.
     */
    public function faviconManagement()
    {
        try {
            $favicon = SiteSetting::get('site_favicon');
            
            return view('admin.content-management.favicon', compact('favicon'));
        } catch (\Exception $e) {
            return redirect()->route('admin.content.index');
        }
    }
    
    /**
     * Update the site favicon.
     */
    public function updateFavicon(Request $request)
    {
        $request->validate([
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:1024',
        ]);
        
        if ($request->hasFile('favicon')) {
            // Delete old favicon if exists
            $oldFavicon = SiteSetting::get('site_favicon');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }
            
            // Process and store favicon
            $file = $request->file('favicon');
            $path = $file->store('favicons', 'public');
            
            // Create ICO version if not already ICO
            if ($file->getClientOriginalExtension() !== 'ico') {
                try {
                    $manager = new ImageManager(new Driver());
                    $image = $manager->read($file);
                    $image = $image->resize(32, 32);
                    
                    $icoPath = 'favicons/favicon.ico';
                    Storage::disk('public')->put($icoPath, $image->toJpeg());
                    $path = $icoPath;
                } catch (\Exception $e) {
                    // Continue with original file if conversion fails
                }
            }
            
            SiteSetting::set('site_favicon', $path);
            
            return redirect()->route('admin.content.favicon')
                ->with('success', 'Favicon updated successfully.');
        }
        
        return redirect()->route('admin.content.favicon')
            ->with('info', 'No changes were made.');
    }
    
    /**
     * Display the page content management page.
     */
    public function pageContentManagement()
    {
        try {
            $pageContents = SiteSetting::where('group', 'page_content')->get();
            
            return view('admin.content-management.page-content', compact('pageContents'));
        } catch (\Exception $e) {
            return redirect()->route('admin.content.index');
        }
    }
    
    /**
     * Update page content.
     */
    public function updatePageContent(Request $request)
    {
        $request->validate([
            'content' => 'required|array',
            'content.*' => 'nullable|string',
        ]);
        
        foreach ($request->input('content') as $key => $value) {
            SiteSetting::set($key, $value);
        }
        
        return redirect()->route('admin.content.page-content')
            ->with('success', 'Page content updated successfully.');
    }
    
    /**
     * Save the uploaded logo to storage.
     */
    public function saveUploadedLogo(Request $request)
    {
        $request->validate([
            'logo_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        if ($request->hasFile('logo_file')) {
            // Store the uploaded logo
            $path = $request->file('logo_file')->store('logos', 'public');
            
            return response()->json([
                'success' => true,
                'path' => $path,
                'url' => Storage::url($path)
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'No file uploaded'
        ], 400);
    }
}
