<?php

namespace App\Repositories;

use App\Models\CustomerPlant;
use App\Models\Plant;
use App\Models\PlantHistory;
use Illuminate\Support\Collection;

class PlantRepository
{
    public function upsertPlantData(array $plants)
    {
        Plant::upsert($plants, ['name_botanical']);
    }

    public function getAllWithHistories(): Collection
    {
        return CustomerPlant::with('histories')->get();
    }

    public function getHistoryStartDate(): ?string
    {
        return PlantHistory::orderBy('created_at')
            ->limit(1)
            ->value('created_at');
    }
}
