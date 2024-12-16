<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'profile_picture' => 'nullable|image|max:1024',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->hasFile('profile_picture')) {
            // Handle profile picture upload
            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->username = $validated['username'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
}
