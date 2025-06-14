<?php

namespace App\Repositories;

use App\Models\PlantType;

class PlantTypeRepository
{
    public function store(array $datas)
    {
        return PlantType::create($datas);
    }

    public function show($name): ?PlantType
    {
        return PlantType::where('type', $name)->first();
    }
}
