<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SpotifyController;

// Routes for Authentication
Route::get('/signin', [AuthController::class, 'showLoginForm'])->name('signin');
Route::post('/signin', [AuthController::class, 'signIn'])->name('signin.submit');

Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signUp'])->name('signup.submit');

// Default route (redirects root URL to Sign In)
Route::get('/', function () {
    return redirect()->route('signin');
})->name('default');

// Routes for Pages
Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/library', function () {
    return view('library');
})->name('library');

// Route for Spotify standalone search page
Route::get('/spotify/search', [SpotifyController::class, 'search'])->name('spotify.search');

// Routes for Playlists
Route::prefix('playlists')->group(function () {
    Route::get('/create', [PlaylistController::class, 'create'])->name('playlists.create');
    Route::post('/', [PlaylistController::class, 'store'])->name('playlists.store');
    Route::get('/{id}', [PlaylistController::class, 'show'])->name('playlists.show');
    
    // Playlist-specific Spotify search
    Route::get('/{playlist}/search', [PlaylistController::class, 'searchSpotify'])->name('playlists.searchSpotify');
    Route::post('/{playlist}/add-song', [PlaylistController::class, 'addSong'])->name('playlists.addSong');
});

Route::get('/spotify/search', [SpotifyController::class, 'searchSpotify'])->name('spotify.search');
Route::get('/spotify/search', [SpotifyController::class, 'searchSpotify'])->name('spotify.search');
