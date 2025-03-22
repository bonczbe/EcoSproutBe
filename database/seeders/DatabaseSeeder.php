<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            DeviceSeeder::class,
            PlantSeeder::class,
            WeatherSeeder::class,
            CustomerPlantSeeder::class,
            PlantHistorySeeder::class,
            DeviceHistorySeeder::class,
            DeviceUserSeeder::class,
        ]);
    }
}
