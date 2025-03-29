<?php

namespace App\Repositories;

use App\Models\Plant;

class PlantRepository
{
    public function upsertPlantData(array $plants)
    {
        Plant::upsert($plants, ['name_botanical']);
    }
}
