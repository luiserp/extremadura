<?php

use App\Http\Controllers\Book\BookDeleteController;
use App\Http\Controllers\Book\BookIndexController;
use App\Http\Controllers\Book\BookDetailController;
use App\Http\Controllers\Book\BookEditController;
use App\Http\Controllers\Book\Api\BookGetActiveBook;
use App\Http\Controllers\Book\BookAskAssistantController;
use App\Http\Controllers\Book\BookCalculateEmbeddingController;
use App\Http\Controllers\Book\BookCalculateSentimentController;
use App\Http\Controllers\Book\BookExportController;
use App\Http\Controllers\Book\BookSetActiveController;
use App\Http\Controllers\Book\BookUpdateController;
use App\Http\Controllers\Navigation\NavigationController;
use App\Http\Controllers\WelcomeController;
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

Route::get('/', WelcomeController::class)->name('welcome');

Route::get('back', [NavigationController::class, 'back'])->name('back');

Route::get('/books', BookIndexController::class)->name('books.index');
Route::get('books/detail/{id}', BookDetailController::class)->name('books.detail');
Route::get('books/export', BookExportController::class)->name('books.export');

Route::group(['middleware' => 'auth'], function () {
    // Books
    Route::get('books/edit/{id}', BookEditController::class)->middleware('can:update,App\Models\Book')->name('books.edit');
    Route::put('books/update/{id}', BookUpdateController::class)->middleware('can:update,App\Models\Book')->name('books.update');
    Route::get('books/set-active/{id}', BookSetActiveController::class)->middleware('can:update,App\Models\Book')->name('books.set-active');
    Route::delete('books/delete/{id}', BookDeleteController::class)->middleware('can:delete,App\Models\Book')->name('books.delete');

    Route::get('books/check-data', BookAskAssistantController::class)->middleware('can:update,App\Models\Book')->name('books.check-data');

    // Book Nlp
    Route::get('books/calculate-embedding', BookCalculateEmbeddingController::class)->middleware('can:update,App\Models\Book')->name('books.calculate-embedding');
    Route::get('books/calculate-sentiment', BookCalculateSentimentController::class)->middleware('can:update,App\Models\Book')->name('books.calculate-sentiment');
});

Route::get('/books/get-active-book', BookGetActiveBook::class)->name('books.get-active-book');
