<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CustomerPlantController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\PlantController;
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
        Route::prefix('device')->group(function () {
            Route::post('store', [DeviceController::class, 'store']);
            Route::put('update', [DeviceController::class, 'update']);
            Route::delete('destroy', [DeviceController::class, 'destroy']);
        });
        Route::prefix('plant')->group(function () {
            Route::prefix('customer')->group(function () {
                Route::post('index', [CustomerPlantController::class, 'index']);
                Route::get('show/{name}', [CustomerPlantController::class, 'show']);
                Route::post('store', [CustomerPlantController::class, 'store']);
                Route::put('update', [CustomerPlantController::class, 'update']);
                Route::delete('destroy', [CustomerPlantController::class, 'destroy']);
            });
            Route::post('index', [PlantController::class, 'index']);
            Route::get('store', [PlantController::class, 'store']);
            Route::post('show/{name}', [PlantController::class, 'show']);
            Route::put('update', [PlantController::class, 'update']);
            Route::delete('destroy', [PlantController::class, 'destroy']);
        });
    });
    Route::middleware('auth:sanctum')->get('test-auth', function () {
        return response()->json(['message' => 'Authenticated!']);
    });
});
