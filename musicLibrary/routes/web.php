<?php

use Illuminate\Support\Facades\Route;

// Route for the Sign In page
Route::get('/signin', function () {
    return view('signin');
})->name('signin');

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
    return view('signin');
})->name('default');
