<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\SongController;

// Homepage (after login)
Route::get('/', function () {
    return view('home'); 
})->middleware('auth');

// Login routes
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');

Route::post('/login', Login::class)->middleware('guest');

// Logout route
Route::post('/logout', Logout::class)->middleware('auth')->name('logout');

// Registration routes
Route::view('/register', 'auth.register')->middleware('guest')->name('register');
Route::post('/register', Register::class)->middleware('guest');

// Playlist / Song routes
Route::middleware('auth')->group(function () {
    // Playlist page
    Route::get('/playlists', [SongController::class, 'index'])->name('playlists.index');

    // Add song page
    Route::get('/songs/create', [SongController::class, 'create'])->name('songs.create');
    Route::post('/songs', [SongController::class, 'store'])->name('songs.store');
});

