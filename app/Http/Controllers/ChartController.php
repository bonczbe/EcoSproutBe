<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceChartRequest;
use App\Http\Requests\PlantChartRequest;
use App\Http\Requests\WeatherChartRequest;
use App\Services\DeviceService;
use App\Services\PlantService;
use App\Services\WeatherService;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();

        return $this->deviceService->getDeviceHistoryDataByDate($validated, $user);

    }

    public function plant(PlantChartRequest $request)
    {
        $validated = $request->validated();
        $user = Auth::user();

        return $this->plantService->getPlantHistoriesByCustomerPlantId($validated, $user);
    }
}
