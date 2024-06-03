<?php

use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PostEditorController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return redirect("/admin/posts");
    });

    Route::get('/posts', [AdminPostController::class, 'show']);
    Route::get('/users', [AdminUserController::class, 'show']);

    Route::post('/createpost', [AdminPostController::class, 'createPost']);
    Route::post('/deletepost', [AdminPostController::class, 'deletePost']);

    Route::get('/editpost/{uuid}', [PostEditorController::class, 'show']);
    Route::post('/savepost', [AdminPostController::class, 'savePost']);

    Route::post('/updateuser', [AdminUserController::class, 'updateUser']);
    Route::post('/updatepassword', [AdminUserController::class, 'updateUserPassword']);
    Route::post('/deleteuser', [AdminUserController::class, 'deleteUser']);
});
