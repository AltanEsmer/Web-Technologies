<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\SpotifyController;
use App\Http\Controllers\LibraryController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TwoFactorAuthController;

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
    // Sign In routes
    Route::get('/signin', [AuthController::class, 'showLoginForm'])->name('signin');
    Route::post('/signin', [AuthController::class, 'signIn'])->name('signin.post');
    
    // Sign Up routes
    Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
    Route::post('/signup', [AuthController::class, 'signUp'])->name('signup.post');
});

// 2FA routes
Route::prefix('2fa')->name('2fa.')->group(function () {
    // Public 2FA routes (for verification during login)
    Route::get('/verify', [TwoFactorAuthController::class, 'showVerifyForm'])
        ->name('verify');
    Route::post('/verify', [TwoFactorAuthController::class, 'verify'])
        ->name('verify.post');
        
    // Protected 2FA routes (for setup and management)
    Route::middleware(['auth'])->group(function () {
        Route::get('/setup', [TwoFactorAuthController::class, 'show2faForm'])
            ->name('setup');
        Route::post('/enable', [TwoFactorAuthController::class, 'enable2fa'])
            ->name('enable');
        Route::post('/disable', [TwoFactorAuthController::class, 'disable2fa'])
            ->name('disable');
        Route::get('/recovery-codes', [TwoFactorAuthController::class, 'showRecoveryCodes'])
            ->name('show-recovery-codes');
        Route::post('/complete-setup', [TwoFactorAuthController::class, 'completeSetup'])
            ->name('complete-setup');
    });
});

// Protected routes (require auth and email verification)
Route::middleware(['auth', 'verified', 'two-factor'])->group(function () {
    Route::get('/library', [LibraryController::class, 'index'])->name('library');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
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

// Logout route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');