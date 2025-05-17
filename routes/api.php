<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChartController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->middleware('web');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('web');

    Route::middleware(['auth:sanctum'])->group(function () {

        Route::prefix('charts')->group(function () {
            Route::post('weather', [ChartController::class, 'weather']);
            Route::post('device', [ChartController::class, 'device']);
            Route::post('plant', [ChartController::class, 'plant']);
        });
    });
});
