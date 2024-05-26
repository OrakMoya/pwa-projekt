<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostEditor;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::middleware(['auth'])->group(function () {
    Route::get('/', [AdminController::class, 'show']);

    Route::post('/createpost', [AdminController::class, 'createPost']);
    Route::post('/deletepost', [AdminController::class, 'deletePost']);

    Route::get('/editpost/{uuid}', [PostEditor::class, 'show']);
    Route::post('/savepost', [AdminController::class, 'savePost']);
});
