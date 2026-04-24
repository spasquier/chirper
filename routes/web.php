<?php

use App\Http\Controllers\Auth\Logout;
use App\Http\Controllers\Auth\Register;
use App\Http\Controllers\ChirpController;
use Illuminate\Support\Facades\Route;

// Homepage route - shows all chirps
Route::get('/', [ChirpController::class, 'index']);

// Rest of Chirp CRUD routes
Route::middleware('auth')->group(function () {
    Route::post('/chirps', [ChirpController::class, 'store']);
    Route::get('/chirps/{chirp}/edit', [ChirpController::class, 'edit']);
    Route::put('/chirps/{chirp}', [ChirpController::class, 'update']);
    Route::delete('/chirps/{chirp}', [ChirpController::class, 'destroy']);
    // These 4 routes are the same as:
    /* Route::resource('chirps', ChirpController::class)
        ->only(['store', 'edit', 'update', 'destroy']); */
});

// Registration routes
Route::view('/register', 'auth.register')
    ->middleware('guest')
    ->name('register');
Route::post('/register', Register::class)
    ->middleware('guest');

// Logout route
Route::post('/logout', Logout::class)
    ->middleware('auth');

