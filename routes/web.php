<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostPublicController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileManagerController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'posts'], function () {
    Route::get('/', [PostController::class, 'index'])->name('posts.index');
    Route::get('/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/', [PostController::class, 'store'])->name('posts.store');
    Route::get('/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::put('/{post}/publicize', [PostController::class, 'publicize'])->name('posts.publicize');
});

Route::group(['prefix' => 'post-publics'], function () {
    Route::get('/', [PostPublicController::class, 'index'])->name('post-publics.index');
    Route::get('/{post}', [PostPublicController::class, 'show'])->name('post-publics.show');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::group(['prefix' => 'manage-files', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', [App\Http\Controllers\FileManagerController::class, 'index'])->name('file-managers.index');
    Route::get('/create', [App\Http\Controllers\FileManagerController::class, 'create'])->name('file-managers.create');
    Route::post('/', [App\Http\Controllers\FileManagerController::class, 'store'])->name('file-managers.store');
    Route::get('/get-files', [App\Http\Controllers\FileManagerController::class, 'files'])->name('file-managers.files');
    Route::get('/{manageFile}/edit', [App\Http\Controllers\FileManagerController::class, 'edit'])->name('file-managers.edit');
    Route::put('/{manageFile}', [App\Http\Controllers\FileManagerController::class, 'update'])->name('file-managers.update');
    Route::delete('/{manageFile}', [App\Http\Controllers\FileManagerController::class, 'destroy'])->name('file-managers.destroy');
});

// Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

require __DIR__.'/auth.php';
