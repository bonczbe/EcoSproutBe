<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
    Route::get('stats', function () {
        return Inertia::render('stats');
    })->name('stats');
    Route::get('devices', function () {
        return Inertia::render('devices');
    })->name('devices');
    Route::get('plants', function () {
        return Inertia::render('plants');
    })->name('plants');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
