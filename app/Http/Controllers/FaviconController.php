<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class FaviconController extends Controller
{
    public function svg()
    {
        $path = public_path('favicon.svg');
        
        if (File::exists($path)) {
            return response(File::get($path))
                ->header('Content-Type', 'image/svg+xml')
                ->header('Cache-Control', 'public, max-age=86400');
        }
        
        // Fallback to the application icon component if file doesn't exist
        return response()
            ->view('components.application-icon', ['attributes' => 'class="h-8 w-8"'], 200)
            ->header('Content-Type', 'image/svg+xml');
    }
}