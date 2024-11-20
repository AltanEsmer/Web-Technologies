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

// Authentication Routes
Route::get('/signin', [AuthController::class, 'showLoginForm'])->name('signin');
Route::post('/signin', [AuthController::class, 'signIn'])->name('signin.submit');
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signUp'])->name('signup.submit');

// Page Routes
Route::get('/home', function () {
    return view('home');
})->name('home');

// Library Route with Controller
Route::get('/library', [LibraryController::class, 'index'])->name('library');

// Spotify Routes
Route::get('/spotify/search', [SpotifyController::class, 'searchSpotify'])->name('spotify.search');

// Playlist Routes
Route::prefix('playlists')->group(function () {
    Route::get('/', [PlaylistController::class, 'index'])->name('playlists.index');
    Route::get('/create', [PlaylistController::class, 'create'])->name('playlists.create');
    Route::post('/', [PlaylistController::class, 'store'])->name('playlists.store');
    Route::get('/{playlist}', [PlaylistController::class, 'show'])->name('playlists.show');
    Route::get('/{playlist}/edit', [PlaylistController::class, 'edit'])->name('playlists.edit');
    Route::put('/{playlist}', [PlaylistController::class, 'update'])->name('playlists.update');
    Route::delete('/{playlist}/songs/{song}', [PlaylistController::class, 'removeSong'])->name('playlists.removeSong');
    Route::get('/{playlist}/search', [PlaylistController::class, 'searchSpotify'])->name('playlists.searchSpotify');
    Route::post('/{playlist}/add-song', [PlaylistController::class, 'addSong'])->name('playlists.addSong');
});