<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'mock'], function () {
    Route::get('/google-play', [\App\Http\Controllers\Api\MockController::class, 'googlePlay']);
    Route::get('/app-store', [\App\Http\Controllers\Api\MockController::class, 'appStore']);
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/statistics/{user}', [\App\Http\Controllers\Api\StatisticsController::class, 'statistics']);
});

