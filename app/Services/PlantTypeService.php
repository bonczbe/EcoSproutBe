<?php

namespace App\Services;

use App\Models\PlantType;
use App\Repositories\PlantTypeRepository;
use Illuminate\Support\Facades\Auth;

class PlantTypeService
{
    public function __construct(private readonly PlantTypeRepository $plantTypeRepository) {}

    public function storePlantTypeIfNotExist(string $plantType, int $minMoist, int $maxMoist): PlantType
    {
        $user = Auth::user('web');
        $primaryPlantType = $this->plantTypeRepository->show($plantType);
        $compositePlantType = $this->plantTypeRepository->show($user->email.'-'.$plantType.'-'.$minMoist.'-'.$maxMoist);
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
                'type' => $user->email.'-'.$plantType.'-'.$minMoist.'-'.$maxMoist,
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
