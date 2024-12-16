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
        $user = Auth::user();

        // Skip 2FA check for these routes
        if ($request->is('2fa/*') || 
            $request->is('logout') || 
            $request->is('login') || 
            $request->is('register')) {
            return $next($request);
        }

        // If no user is logged in
        if (!$user) {
            if ($request->session()->has('2fa.user_id')) {
                return redirect()->route('2fa.verify');
            }
            return $next($request);
        }

        // If user has 2FA enabled but hasn't verified this session
        if ($user->two_factor_confirmed_at && !session('2fa_verified')) {
            Auth::logout();
            session(['2fa.user_id' => $user->id]);
            return redirect()->route('2fa.verify');
        }

        return $next($request);
    }
}
