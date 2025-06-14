<?php

namespace App\Repositories;

use App\Models\CustomerPlant;
use Illuminate\Support\Collection;

class CustomerPlantRepository
{
    public function getAllCustomerPlantIdWithPlantNameForUser($user): Collection
    {
        return CustomerPlant::with(['plant.plantType', 'plantType'])
            ->forUser($user)
            ->get();
    }

    public function store(array $datas)
    {
        return CustomerPlant::create($datas);
    }
}
