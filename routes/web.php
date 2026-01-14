<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\SongController;
use App\Http\Controllers\PlaylistController;

// Homepage
Route::get('/', fn() => view('home'))->middleware('auth')->name('home');

// Login & Register
Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::post('/login', Login::class);
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', Register::class);
});

// Logout
Route::post('/logout', Logout::class)->middleware('auth')->name('logout');

// Playlist & Song routes
Route::middleware('auth')->group(function () {

    // Playlist page & edit
    Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists.index');
    Route::get('/playlists/edit', [PlaylistController::class, 'edit'])->name('playlist.edit');
    Route::put('/playlists/update', [PlaylistController::class, 'update'])->name('playlists.update');

    // Song CRUD
    Route::get('/songs/create', [SongController::class, 'create'])->name('songs.create');
    Route::post('/songs', [SongController::class, 'store'])->name('songs.store');
    Route::get('/songs/{song}/edit', [SongController::class, 'edit'])->name('songs.edit');
    Route::put('/songs/{song}', [SongController::class, 'update'])->name('songs.update');
    Route::delete('/songs/{song}', [SongController::class, 'destroy'])->name('songs.destroy');
});
