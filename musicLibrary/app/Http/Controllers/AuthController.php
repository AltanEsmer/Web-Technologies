<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('signin');
    }

    // Show the signup form
    public function showSignupForm()
    {
        return view('signup');
    }

    // Handle the Sign In form submission
    public function signIn(Request $request)
    {
        $credentials = $request->validate([
            'mail' => 'required|email',
            'pass' => 'required',
        ]);

        if (Auth::attempt(['email' => $credentials['mail'], 'password' => $credentials['pass']], $request->has('checker'))) {
            $user = Auth::user();
            
            \Log::info('User logged in successfully', [
                'user_id' => $user->id,
                'has_2fa' => (bool)$user->two_factor_secret,
                'two_factor_confirmed' => (bool)$user->two_factor_confirmed_at
            ]);
            
            if ($user->two_factor_secret && $user->two_factor_confirmed_at) {
                Auth::logout();
                session(['2fa.user_id' => $user->id]);
                return redirect()->route('2fa.verify');
            }

            $request->session()->regenerate();
            return redirect()->intended(route('library'));
        }

        return back()
            ->withInput($request->only('mail'))
            ->withErrors([
                'mail' => 'The provided credentials do not match our records.',
            ]);
    }

    // Handle the Sign Up form submission
    public function signUp(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'mail' => 'required|string|email|max:255|unique:users,email',
            'pass' => 'required|string|min:6|confirmed',
            'pass_confirmation' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $validated['username'],
            'email' => $validated['mail'],
            'password' => Hash::make($validated['pass']),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('signin');
    }
}