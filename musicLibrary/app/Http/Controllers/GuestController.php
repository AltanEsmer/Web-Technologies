<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    /**
     * Handle guest login.
     */
    public function loginAsGuest(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'username' => 'required|string|max:255',
        ]);

        // Create the guest user
        $user = User::create([
            'name' => $request->username,
            'email' => 'guest_' . uniqid() . '@example.com', // Generate unique email
            'password' => bcrypt('guest_password'),          // Dummy password
            'user_type' => 'guest',                          // Set user_type to 'guest'
        ]);

        // Log in the guest user
        Auth::login($user);

        // Return a JSON response
        return response()->json([
            'status' => 'success',
            'message' => 'Guest user logged in successfully.',
            'user' => $user,
            'redirect' => route('library')
        ]);
    }
}
