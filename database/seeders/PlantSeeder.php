<?php

namespace Database\Seeders;

use App\Models\Plant;
use Illuminate\Database\Seeder;

class PlantSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = database_path('seeders/files/plants.csv');
        $handle = fopen($filePath, 'r');

        // Skip the header
        fgetcsv($handle);

        $batchSize = 500;
        $batch = [];

        while (($row = fgetcsv($handle)) !== false) {
            $batch[] = [
                'name_botanical' => $row[0],
                'name_en' => $row[1],
                'name_hu' => $row[2],
                'default_image' => $row[3],
                'species_epithet' => $row[4],
                'genus' => $row[5],
                'plant_type_id' => (int) $row[6],
                'family' => $row[7],
                'family_hu' => $row[8] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            if (count($batch) >= $batchSize) {
                Plant::insert($batch);
                $batch = [];
            }
        }

        // Insert remaining rows
        if (! empty($batch)) {
            Plant::insert($batch);
        }

        fclose($handle);
    }
}
