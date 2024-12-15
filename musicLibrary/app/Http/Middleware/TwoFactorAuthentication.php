<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class TwoFactorAuthentication
{
    public function handle(Request $request, Closure $next)
    {
        // Skip 2FA check for verification and setup routes
        if ($request->is('2fa/*')) {
            return $next($request);
        }

        $user = Auth::user();

        // If no user is logged in
        if (!$user) {
            // If there's a pending 2FA verification
            if ($request->session()->has('2fa.user_id')) {
                return redirect()->route('2fa.verify');
            }
            // Otherwise, let the request continue (guest middleware will handle redirection)
            return $next($request);
        }

        // If user has 2FA enabled but hasn't verified this session
        if ($user->two_factor_confirmed_at && !session('2fa_verified')) {
            Auth::logout();
            $request->session()->put('2fa.user_id', $user->id);
            return redirect()->route('2fa.verify');
        }

        return $next($request);
    }
}
