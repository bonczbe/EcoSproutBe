<?php

use App\Http\Controllers\ChartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json(['message' => 'Hello, API!']);
});
Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::group(
    [],// ['middleware' => 'auth:sanctum'],
    function () {
        Route::prefix('charts')->group(function () {
            Route::post('weather', [ChartController::class, 'weather']);
            Route::post('device', [ChartController::class, 'device']);
            Route::post('plant', [ChartController::class, 'plant']);
        });
    });
