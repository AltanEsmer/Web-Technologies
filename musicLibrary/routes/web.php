<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route for showing the Sign In page
Route::get('/signin', [AuthController::class, 'showLoginForm'])->name('signin');

// Route for handling the Sign In form submission
Route::post('/signin', [AuthController::class, 'signIn'])->name('signin.submit');

// Route for handling the Sign Up form submission
Route::post('/signup', [AuthController::class, 'signUp'])->name('signup.submit');

// Route for the Home page
Route::get('/home', function () {
    return view('home');
})->name('home');

// Route for the Library page
Route::get('/library', function () {
    return view('library');
})->name('library');

// Set the default route to Sign In if you want the root URL to show the Sign In page
Route::get('/', function () {
    return redirect()->route('signin');
})->name('default');

//playlist view and creation
use App\Http\Controllers\PlaylistController;

Route::get('/playlist/{id}', [PlaylistController::class, 'show'])->name('playlist.show');
Route::get('/playlist/create', [PlaylistController::class, 'create'])->name('playlist.create');

