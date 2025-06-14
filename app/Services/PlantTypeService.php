<?php

namespace App\Services;

use App\Models\PlantType;
use App\Repositories\PlantTypeRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PlantTypeService
{
    public function __construct(private readonly PlantTypeRepository $plantTypeRepository) {}

    public function storePlantTypeIfNotExist(string $plantType, int $minMoist, int $maxMoist): PlantType
    {
        $user = Auth::user('web');

        $customTypeName = Str::slug($user->email).','.$plantType.','.$minMoist.','.$maxMoist;
        $primaryPlantType = $this->plantTypeRepository->show($plantType);
        $compositePlantType = $this->plantTypeRepository->show($customTypeName);

        if (
            (
                $primaryPlantType === null
                && $compositePlantType === null
            ) ||
            (
                $primaryPlantType !== null
                && $primaryPlantType->max_soil_moisture != $maxMoist
                && $primaryPlantType->min_soil_moisture != $minMoist
            )
        ) {
            return $this->plantTypeRepository->store([
                'type' => $customTypeName,
                'min_soil_moisture' => $minMoist,
                'max_soil_moisture' => $maxMoist,
            ]);
        }
        if ($compositePlantType !== null) {
            return $compositePlantType;
        }

        return $primaryPlantType;
    }
}
