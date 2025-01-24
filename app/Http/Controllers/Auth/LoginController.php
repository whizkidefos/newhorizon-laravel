<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;
    protected $maxAttempts = 5; // Maximum login attempts
    protected $decayMinutes = 15; // Lockout time in minutes

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        // Check if the user is already locked out
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $seconds = $this->limiter()->availableIn(
                $this->throttleKey($request)
            );

            return back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    'email' => __('Too many login attempts. Please try again in :minutes minutes.', [
                        'minutes' => ceil($seconds / 60),
                    ]),
                ]);
        }

        if ($this->attemptLogin($request)) {
            // Check for suspicious login
            if ($this->isSuspiciousLogin($request)) {
                $this->sendSuspiciousLoginNotification($request->user());
            }

            return $this->sendLoginResponse($request);
        }

        // Increment failed login attempts
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function isSuspiciousLogin(Request $request)
    {
        $user = $request->user();
        $lastLogin = $user->last_login_ip;
        $currentIp = $request->ip();

        // Store the new login information
        $user->update([
            'last_login_at' => now(),
            'last_login_ip' => $currentIp
        ]);

        // Check if IP is different from last login
        return $lastLogin && $lastLogin !== $currentIp;
    }

    protected function sendSuspiciousLoginNotification($user)
    {
        $user->notify(new \App\Notifications\SuspiciousLogin);
    }
}