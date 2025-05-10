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

    public function getAllCustomerPlantIdWithPlantNameForUser($user): Collection
    {
        return CustomerPlant::with(['plant'])
            ->forUser($user)
            ->get();
    }

    public function getHistoryStartDateForUser($user): ?string
    {
        return PlantHistory::forUser($user)
            ->orderBy('created_at')
            ->limit(1)
            ->value('created_at');
    }

    public function getHistoryByFilters($plantId, $startDate, $endDate, $user): array
    {
        return PlantHistory::query()
            ->forUser($user)
            ->where('customer_plant_id', $plantId)
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->get()
            ->toArray();
    }
}
