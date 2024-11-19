<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SpotifyController;

// Authentication Routes
Route::get('/signin', [AuthController::class, 'showLoginForm'])->name('signin');
Route::post('/signin', [AuthController::class, 'signIn'])->name('signin.submit');
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signUp'])->name('signup.submit');

// Default route
Route::get('/', function () {
    return redirect()->route('signin');
})->name('default');

// Page Routes
Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/library', function () {
    return view('library');
})->name('library');

// Spotify Routes
Route::get('/spotify/search', [SpotifyController::class, 'searchSpotify'])->name('spotify.search');

// Playlist Routes
Route::prefix('playlists')->group(function () {
    Route::get('/', [PlaylistController::class, 'index'])->name('playlists.index');
    Route::get('/create', [PlaylistController::class, 'create'])->name('playlists.create');
    Route::post('/', [PlaylistController::class, 'store'])->name('playlists.store');
    Route::get('/{playlist}', [PlaylistController::class, 'show'])->name('playlists.show');
    Route::get('/{playlist}/search', [PlaylistController::class, 'searchSpotify'])->name('playlists.searchSpotify');
    Route::post('/{playlist}/add-song', [PlaylistController::class, 'addSong'])->name('playlists.addSong');
});

Route::get('/playlists/{playlist}/edit', [PlaylistController::class, 'edit'])->name('playlists.edit');
Route::put('/playlists/{playlist}', [PlaylistController::class, 'update'])->name('playlists.update');
Route::delete('/playlists/{playlist}/songs/{song}', [PlaylistController::class, 'removeSong'])->name('playlists.removeSong');