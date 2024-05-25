<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render("Home");
});
Route::get('/login', [LoginController::class, 'show'] )->name('login');
Route::post('/login', [LoginController::class, 'store'] );
Route::get('/logout', [LoginController::class, 'discard'] );

Route::get('/signup', [SignupController::class, 'show'] )->name('register');
Route::post('/signup', [SignupController::class, 'store'] );
