MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@example.com
MAIL_FROM_NAME="${APP_NAME}"<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\LibraryController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
//for now here just for testing
use App\Http\Controllers\ProfileController;

// Public routes
Route::get('/', function () {
    return view('home');
})->name('home');

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

// Email verification routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->route('library')->with('status', 'Email verified!');
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('status', 'Verification link sent!');
    })->middleware(['throttle:6,1'])->name('verification.send');
});

// Protected routes (require auth and email verification)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/library', [LibraryController::class, 'index'])->name('library');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Playlist routes
    Route::resource('playlists', PlaylistController::class);
    Route::get('/playlists/{playlist}/search', [PlaylistController::class, 'searchSpotify'])
        ->name('playlists.searchSpotify');
    Route::post('/playlists/{playlist}/songs', [PlaylistController::class, 'addSong'])
        ->name('playlists.addSong');
    Route::delete('/playlists/{playlist}/songs/{song}', [PlaylistController::class, 'removeSong'])
        ->name('playlists.removeSong');
    
    // Spotify search
    Route::get('/spotify/search', [SpotifyController::class, 'searchSpotify'])->name('spotify.search');
});

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');