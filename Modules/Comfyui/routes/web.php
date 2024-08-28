<?php

use Illuminate\Support\Facades\Route;
use Modules\Comfyui\app\Http\Controllers\ComfyUIController;

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
    Route::get('comfyui', ComfyUIController::class)->name('comfyui');
});
