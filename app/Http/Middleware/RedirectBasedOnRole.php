<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return $next($request);
        }

        // If accessing the home page, redirect based on role
        if ($request->is('/')) {
            if ($request->user()->hasRole('super-admin') || $request->user()->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('profile.index');
            }
        }

        return $next($request);
    }
}
