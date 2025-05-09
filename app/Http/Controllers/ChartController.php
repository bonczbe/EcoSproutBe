<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceChartRequest;
use App\Http\Requests\PlantChartRequest;
use App\Http\Requests\WeatherChartRequest;
use App\Models\PlantHistory;
use App\Services\DeviceService;
use App\Services\PlantService;
use App\Services\WeatherService;

class ChartController extends Controller
{
    public function __construct(private DeviceService $deviceService, private WeatherService $weatherService, private PlantService $plantService) {}

    public function weather(WeatherChartRequest $request)
    {
        $validated = $request->validated();

        return $this->weatherService->getWeatherByFilters($validated);
    }

    public function device(DeviceChartRequest $request)
    {
        $validated = $request->validated();

        return $this->deviceService->getDeviceHistoryDataByDate($validated);

    }

    public function plant(PlantChartRequest $request)
    {
        $validated = $request->validated();

        return $this->plantService->getPlantHistoriesByCustomerPlantId($validated);
    }
}
