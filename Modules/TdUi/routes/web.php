<?php

use Illuminate\Support\Facades\Route;
use Modules\TdUi\Http\Controllers\TdUiController;

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

Route::group([], function () {
    Route::resource('tdui', TdUiController::class)->names('tdui');
});
