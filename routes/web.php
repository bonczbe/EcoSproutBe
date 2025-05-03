<?php

use App\Models\Device;
use App\Models\Weather;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        $user = auth('web')->user();
        $filtersRaw = Weather::query()
            ->select('city', 'time_zone', 'date')
            ->get();

        $cities = $filtersRaw->pluck('city')->filter()->unique()->values();
        $startDate = $filtersRaw->pluck('date')->filter()->unique()->sort()->values()[0]??null;


        return Inertia::render('dashboard', [
            'user' => $user->toArray(),
            'filters' => [
                'cities' => $cities,
                'startDate' => $startDate,
                'devices' => Device::query()->with("customer_plants.plant")->get(),
            ],
        ]);
    })->name('dashboard');
    Route::get('devices', function () {
        return Inertia::render('devices');
    })->name('devices');
    Route::get('plants', function () {
        return Inertia::render('plants');
    })->name('plants');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
