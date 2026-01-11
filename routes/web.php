<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\SongController;

// Homepage (after login)
Route::get('/', function () {
    return view('home'); 
})->middleware('auth')->name('home');

// Login routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', Login::class);
    
    Route::view('/register', 'auth.register')->name('register');
    Route::post('/register', Register::class);
});

// Logout route
Route::post('/logout', Logout::class)->middleware('auth')->name('logout');

// Playlist and Song routes
Route::middleware('auth')->group(function () {

    // Playlist page - list all songs
    Route::get('/playlists', [SongController::class, 'index'])->name('playlists.index');

    // Song CRUD
    Route::get('/songs/create', [SongController::class, 'create'])->name('songs.create');
    Route::post('/songs', [SongController::class, 'store'])->name('songs.store');
    Route::get('/songs/{song}/edit', [SongController::class, 'edit'])->name('songs.edit');
    Route::put('/songs/{song}', [SongController::class, 'update'])->name('songs.update');
    Route::delete('/songs/{song}', [SongController::class, 'destroy'])->name('songs.destroy');

    // Playlist name edit
    Route::get('/playlists/edit', [SongController::class, 'editPlaylist'])->name('playlist.edit');
    Route::put('/playlists/update', [SongController::class, 'updatePlaylist'])->name('playlists.update');
});
