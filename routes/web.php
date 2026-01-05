<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Login;
use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;


Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

// Login routes
Route::get('/login', function () {
    return view('auth.login');
})->middleware('guest')->name('login');
 
Route::post('/login', Login::class)
    ->middleware('guest');
 
// Logout route
Route::post('/logout', Logout::class)
    ->middleware('auth')
    ->name('logout');

// Registration routes
Route::view('/register', 'auth.register')
    ->middleware('guest')
    ->name('register');
 
Route::post('/register', Register::class)
    ->middleware('guest');
