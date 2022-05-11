<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImageController;
// use App\Http\Controllers\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth'])->group(function () {
    Route::get('posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('posts/store', [PostController::class, 'store'])->name('posts.store');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::get('posts/{postSlug}/edit', [PostController::class, 'edit'])->name('posts.edit');
    // Route::get('posts/{postId}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::post('posts/{postId}', [PostController::class, 'restore'])->name('posts.restore');
    Route::delete('posts/{postId}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::delete('posts/{postId}/delete', [PostController::class, 'delete'])->name('posts.delete');
    Route::get('posts/{postSlug}', [PostController::class, 'show'])->name('posts.show');
    // Route::get('posts/{postId}', [PostController::class, 'show'])->name('posts.show');
});

Auth::routes();

Route::get('imgs', [ImageController::class, 'index'])->name('imgs.index');
Route::post('imgs/upload', [ImageController::class, 'upload'])->name('imgs.upload');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
