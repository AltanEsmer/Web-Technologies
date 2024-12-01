<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
        // Validate the input
        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'mail' => 'required|email|unique:users,email',
            'pass' => 'required|min:6|confirmed',
        ]);

        // Create the new user
        $user = User::create([
            'name' => $request->username,
            'email' => $request->mail,
            'password' => Hash::make($request->pass),
        ]);

        // Automatically log the user in after they sign up
        Auth::login($user);

        return redirect()->route('library'); // Changed to redirect to library
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('signin');
    }
}