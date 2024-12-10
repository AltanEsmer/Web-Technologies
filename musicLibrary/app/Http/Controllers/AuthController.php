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

    // Handle the Sign In form submission
    public function signIn(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'mail' => 'required|email',
            'pass' => 'required|min:6',
        ]);

        // Attempt to log the user in
        if (Auth::attempt(['email' => $request->mail, 'password' => $request->pass], $request->has('checker'))) {
            return redirect()->route('library'); // Changed to redirect to library
        }

        // If login fails, redirect back with an error message
        return redirect()->back()->withErrors(['msg' => 'Invalid credentials!'])->withInput();
    }

    // Handle the Sign Up form submission
    public function signUp(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'mail' => 'required|string|email|max:255|unique:users,email',
            'pass' => 'required|string|min:6|confirmed',
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

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('signin');
    }
}