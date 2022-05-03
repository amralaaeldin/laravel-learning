<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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

Route::get('posts', [PostController::class, 'index'])->name('posts.index');
Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('posts/store', [PostController::class, 'store'])->name('posts.store');
Route::put('posts/update', [PostController::class, 'update'])->name('posts.update');
Route::get('posts/{postId}/edit', [PostController::class, 'edit'])->name('posts.edit');
Route::post('posts/{postId}', [PostController::class, 'restore'])->name('posts.restore');
Route::delete('posts/{postId}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::delete('posts/{postId}/delete', [PostController::class, 'delete'])->name('posts.delete');
Route::get('posts/{postId}', [PostController::class, 'show'])->name('posts.show');
