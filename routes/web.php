<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('devices', function () {
        return Inertia::render('devices');
    })->name('devices');
    Route::get('plants', function () {
        return Inertia::render('plants');
    })->name('plants');

        Route::prefix('charts')->group(function () {
            Route::post('weather', [ChartController::class, 'weather']);
            Route::post('device', [ChartController::class, 'device']);
            Route::post('plant', [ChartController::class, 'plant']);
        });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
