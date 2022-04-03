<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ {
    SearchGameController,
    SearchClipController,
    PopularClipController,
};

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

Route::prefix('clips')
    ->as('clips')
    ->name('clips.')
    ->group(function () {
        Route::get('popular', PopularClipController::class)->name('popular');
        Route::get('search', SearchClipController::class)->name('search');
    });

Route::prefix('games')
    ->as('games')
    ->name('games.')
    ->group(function () {
        Route::get('search', SearchGameController::class)->name('search');
    });
