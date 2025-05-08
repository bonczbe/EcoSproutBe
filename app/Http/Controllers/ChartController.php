<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceChartRequest;
use App\Http\Requests\WeatherChartRequest;
use App\Models\DeviceHistory;
use App\Models\Weather;use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{

    public function weather(WeatherChartRequest $request)
    {
        $validated = $request->validated();

        $query = Weather::query();

        if (strtolower($validated['city']) != 'all') {
            $query->where('city', $validated['city']);
        }

        $startDate = $validated['startDate'];
        $endDate = $validated['endDate'] ?? '9999-12-30';

        return $query
            ->whereBetween('date', [$startDate, $endDate])
            ->get()
            ->toArray();

    }

    public function device(DeviceChartRequest $request)
    {
        $validated = $request->validated();
        $startDate = $validated['startDate'];
        $endDate = $validated['endDate'] ?? '9999-12-30';

        if ($validated['device'] != -1) {
            return DeviceHistory::query()
                ->where('device_id', $validated['device'])
                ->whereBetween('updated_at', [$startDate, $endDate])
                ->get()
                ->toArray();
        } else {
            return DeviceHistory::select([
                DB::raw("updated_at"),
                DB::raw("AVG(water_level) as water_level"),
                DB::raw("AVG(temperature) as temperature"),
            ])
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->groupBy("updated_at")
            ->orderBy('updated_at')
            ->get()
            ->toArray();
        }

    }
}
