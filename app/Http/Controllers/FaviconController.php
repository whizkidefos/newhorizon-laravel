<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class FaviconController extends Controller
{
    public function svg()
    {
        return response()
            ->view('components.application-icon', ['attributes' => 'class="h-8 w-8"'], 200)
            ->header('Content-Type', 'image/svg+xml');
    }
}