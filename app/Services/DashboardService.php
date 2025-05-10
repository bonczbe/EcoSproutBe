<?php

namespace App\Services;

use App\Repositories\DeviceRepository;
use App\Repositories\PlantRepository;
use App\Repositories\WeatherRepository;

class DashboardService
{
    public function __construct(
        protected WeatherRepository $weatherRepo,
        protected DeviceRepository $deviceRepo,
        protected PlantRepository $plantRepo
    ) {}

    public function getDashboardData($user): array
    {
        $weatherRecords = $this->weatherRepo->getWeatherFilters();
        $cities = $weatherRecords->pluck('city')->filter()->unique()->values();
        $weatherStartDate = $weatherRecords->pluck('date')->filter()->unique()->sort()->values()->first();

        $devices = $this->deviceRepo->getAllWithHistoriesForUser($user);
        $deviceStartDate = $this->deviceRepo->getHistoryStartDateForUser($user);

        $plants = $this->plantRepo->getAllCustomerPlantIdWithPlantNameForUser($user)
            ->map(function ($customerPlant) {
                return [
                    'customer_plant_id' => $customerPlant->id,
                    'plant_name_botanical' => $customerPlant->plant->name_botanical,
                ];
            })
            ->toArray();
        $plantStartDate = $this->plantRepo->getHistoryStartDateForUser($user);

        return [
            'weather' => [
                'cities' => $cities,
                'startDate' => $weatherStartDate,
            ],
            'devices' => [
                'devices' => $devices,
                'startDate' => $deviceStartDate,
            ],
            'plants' => [
                'plants' => $plants,
                'startDate' => $plantStartDate,
            ],
        ];
    }
}
