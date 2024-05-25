<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware(['auth'])->group(function () {
    Route::get('/', [AdminController::class, 'show']);

    Route::post('/createpost', [AdminController::class, 'createPost']);
    Route::post('/deletepost', [AdminController::class, 'deletePost']);
});
