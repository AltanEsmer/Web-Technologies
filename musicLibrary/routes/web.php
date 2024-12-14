<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\LibraryController;
//for now here just for testing
use App\Http\Controllers\ProfileController;

//for guest user
use App\Http\Controllers\GuestController;

Route::post('/guest-login', [GuestController::class, 'loginAsGuest']);

//for edit profile
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
//^
// Default route (Home page)
Route::get('/', function () {
    return view('home');
})->name('home');

// Public routes (accessible to everyone)
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Guest routes (only for non-authenticated users)
Route::middleware('guest')->group(function () {
    Route::get('/signin', [AuthController::class, 'showLoginForm'])->name('signin');
    Route::post('/signin', [AuthController::class, 'signIn'])->name('signin.submit');
    Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
    Route::post('/signup', [AuthController::class, 'signUp'])->name('signup.submit');
});

// Protected Routes (Require Authentication)
Route::middleware('auth')->group(function () {
    
    //profile edit auth
    Route::get('/profile', function () {
        if (Auth::check() && Auth::user()->user_type === 'guest') {
            return response()->json([
                'status' => 'error',
                'message' => 'Guest users cannot edit profiles.',
            ], 403); // Return 403 Forbidden status with a JSON error message
        }
        return app(ProfileController::class)->edit();
    })->name('profile.edit');

    Route::post('/profile', function () {
        if (Auth::check() && Auth::user()->user_type === 'guest') {
            return response()->json([
                'status' => 'error',
                'message' => 'Guest users cannot edit profiles.',
            ], 403); // Return 403 Forbidden status with a JSON error message
        }
        return app(ProfileController::class)->update(request());
    })->name('profile.update');
    Route::get('/playlists/create', [PlaylistController::class, 'create'])->name('playlists.create');
    Route::post('/playlists', [PlaylistController::class, 'store'])->name('playlists.store');
    //restriction for playlist creation
    Route::get('/playlists/create', function () {
        if (Auth::check() && Auth::user()->user_type === 'guest') {
            return response()->json([
                'status' => 'error',
                'message' => 'Guest users cannot create playlists.',
            ], 403); // Return 403 Forbidden status with a JSON error message
        }
        return app(PlaylistController::class)->create();
    })->name('playlists.create');

    Route::post('/playlists/create', function () {
        if (Auth::check() && Auth::user()->user_type === 'guest') {
            return response()->json([
                'status' => 'error',
                'message' => 'Guest users cannot create playlists.',
            ], 403); // Return 403 Forbidden status with a JSON error message
        }
        return app(PlaylistController::class)->store(request());
    })->name('playlists.store');

    // Library Routes
    Route::get('/library', [LibraryController::class, 'index'])->name('library');
    
    // Playlist Routes
    Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists.index');
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
    
    // Playlist Reorder Route
    Route::post('/playlists/{playlist}/reorder', [PlaylistController::class, 'reorderSongs'])
        ->name('playlists.reorderSongs');
});

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');