<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\LibraryController;

// Default route
Route::get('/', function () {
    return redirect()->route('signin');
})->name('default');

// Authentication Routes (Public)
Route::middleware('guest')->group(function () {
    Route::get('/signin', [AuthController::class, 'showLoginForm'])->name('signin');
    Route::post('/signin', [AuthController::class, 'signIn'])->name('signin.submit');
    Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
    Route::post('/signup', [AuthController::class, 'signUp'])->name('signup.submit');
});

// Protected Routes (Require Authentication)
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
    
    // Library Routes
    Route::get('/library', [LibraryController::class, 'index'])->name('library');
    
    // Playlist Routes
    Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists.index');
    Route::get('/playlists/create', [PlaylistController::class, 'create'])->name('playlists.create');
    Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlists.store');
    Route::get('/playlists/{playlist}', [PlaylistController::class, 'show'])->name('playlists.show');
    Route::get('/playlists/{playlist}/edit', [PlaylistController::class, 'edit'])->name('playlists.edit');
    Route::put('/playlists/{playlist}', [PlaylistController::class, 'update'])->name('playlists.update');
    Route::delete('/playlists/{playlist}', [PlaylistController::class, 'destroy'])->name('playlists.destroy');
    
    // Playlist Song Management Routes
    Route::get('/playlists/{playlist}/search', [PlaylistController::class, 'searchSpotify'])
        ->name('playlists.searchSpotify');
    Route::post('/playlists/{playlist}/songs', [PlaylistController::class, 'addSong'])
        ->name('playlists.addSong');
    Route::delete('/playlists/{playlist}/songs/{song}', [PlaylistController::class, 'removeSong'])
        ->name('playlists.removeSong');
    
    // Spotify Search Route
    Route::get('/spotify/search', [SpotifyController::class, 'searchSpotify'])->name('spotify.search');
});

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');