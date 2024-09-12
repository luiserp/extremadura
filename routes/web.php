<?php

use App\Http\Controllers\Book\BookDeleteController;
use App\Http\Controllers\Book\BookIndexController;
use App\Http\Controllers\Book\BookDetailController;
use App\Http\Controllers\Book\BookEditController;
use App\Http\Controllers\Book\Api\BookGetActiveBook;
use App\Http\Controllers\Book\BookAskAssistantController;
use App\Http\Controllers\Book\BookCalculateEmbeddingController;
use App\Http\Controllers\Book\BookCalculateSentimentController;
use App\Http\Controllers\Book\BookCalculateStatsController;
use App\Http\Controllers\Book\BookExportController;
use App\Http\Controllers\Book\BookGenerateImageController;
use App\Http\Controllers\Book\BookSetActiveController;
use App\Http\Controllers\Book\BookUpdateController;
use App\Http\Controllers\Book\ImportBookController;
use App\Http\Controllers\Book\DeleteAllBooksController;
use App\Http\Controllers\BookDescription\BookCreateDescriptionController;
use App\Http\Controllers\Devtools\DevtoolsController;
use App\Http\Controllers\Devtools\TestBroadcastingController;
use App\Http\Controllers\Navigation\NavigationController;
use App\Http\Controllers\OllamaTestController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

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
    Route::delete('books/delete-all', DeleteAllBooksController::class)->middleware('can:delete,App\Models\Book')->name('books.delete-all');

    Route::get('books/check-data', BookAskAssistantController::class)->middleware('can:update,App\Models\Book')->name('books.check-data');

    Route::post('books/import', ImportBookController::class)->name('books.import');

    // Book Nlp
    Route::get('books/calculate-embedding', BookCalculateEmbeddingController::class)->middleware('can:update,App\Models\Book')->name('books.calculate-embedding');
    Route::get('books/calculate-sentiment', BookCalculateSentimentController::class)->middleware('can:update,App\Models\Book')->name('books.calculate-sentiment');

    // Stats
    Route::get('books/calculate-stats', BookCalculateStatsController::class)->middleware('role:admin')->name('books.calculate-stats');

    // Book Description
    Route::get('books/create-description', BookCreateDescriptionController::class)->middleware('can:update,App\Models\Book')->name('books.create-description');

    // Image generation
    Route::get('books/generate-image', BookGenerateImageController::class)->middleware('can:update,App\Models\Book')->name('books.generate-image');
});

Route::get('/books/get-active-book', BookGetActiveBook::class)->name('books.get-active-book');

// Devtools
Route::get('/devtools/broadcasting-test', TestBroadcastingController::class)->name('devtools.broadcasting-test');
Route::get('/devtools', DevtoolsController::class)->name('devtools.index');


// Ollama
Route::get('/ollama', OllamaTestController::class)->name('ollama');
