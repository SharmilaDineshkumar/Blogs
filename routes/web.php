<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AuthorController;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/', [PostController::class, 'index'])->name('posts.index');

Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class)->except(['index']);

    Route::post('posts/{post}/like', [LikeController::class, 'store'])->name('posts.like');
    Route::delete('posts/{post}/like', [LikeController::class, 'destroy'])->name('posts.unlike');

    Route::middleware('auth')->group(function () {
        Route::resource('authors', AuthorController::class)->except(['create', 'store']);
        Route::get('authors/{author}/edit', [AuthorController::class, 'edit'])->name('authors.edit');
        Route::put('authors/{author}', [AuthorController::class, 'update'])->name('authors.update');
        Route::delete('authors/{author}', [AuthorController::class, 'destroy'])->name('authors.destroy');
    });
});

require __DIR__.'/auth.php';
