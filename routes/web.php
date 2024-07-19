<?php

use App\Http\Controllers\Book\BookDeleteController;
use App\Http\Controllers\Book\BookIndexController;
use App\Http\Controllers\Book\BookDetailController;
use App\Http\Controllers\Book\BookEditController;
use App\Http\Controllers\Book\BookUpdateController;
use App\Http\Controllers\Navigation\NavigationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
require __DIR__.'/auth.php';

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('back', [NavigationController::class, 'back'])->name('back');


Route::group(['middleware' => 'auth'], function () {
    // Books
    Route::get('/books', BookIndexController::class)->name('books.index');
    Route::get('books/detail/{id}', BookDetailController::class)->name('books.detail');
    Route::get('books/edit/{id}', BookEditController::class)->name('books.edit');
    Route::get('books/update/{id}', BookUpdateController::class)->name('books.update');
    Route::delete('books/delete/{id}', BookDeleteController::class)->name('books.delete');
});
