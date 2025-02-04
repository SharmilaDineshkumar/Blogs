<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', [PostController::class, 'index'])->name('posts.index');

Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class)->except(['index']);

    Route::post('posts/{post}/like', [LikeController::class, 'store'])->name('posts.like');
    Route::delete('posts/{post}/like', [LikeController::class, 'destroy'])->name('posts.unlike');

    Route::get('profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

