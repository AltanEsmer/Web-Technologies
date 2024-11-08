<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlaylistController;

// Routes for Authentication
Route::get('/signin', [AuthController::class, 'showLoginForm'])->name('signin');
Route::post('/signin', [AuthController::class, 'signIn'])->name('signin.submit');

Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signUp'])->name('signup.submit');

// Routes for Pages
Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/library', function () {
    return view('library');
})->name('library');

// Default route (redirects root URL to Sign In)
Route::get('/', function () {
    return redirect()->route('signin');
})->name('default');

// Routes for Playlist
Route::get('/playlist/{id}', [PlaylistController::class, 'show'])->name('playlist.show');
Route::get('/playlist/create', [PlaylistController::class, 'create'])->name('playlist.create');
