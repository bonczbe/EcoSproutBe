<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeviceChartRequest;
use App\Http\Requests\WeatherChartRequest;
use App\Models\DeviceHistory;
use App\Models\Weather;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
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
    /**
     * Show the form for creating a new resource.
     */
    public function device(DeviceChartRequest $request)
    {
        $validated = $request->validated();

        $query = DeviceHistory::query();

        if (strtolower($validated['device']) != 'all') {
            $query->where('device_id', $validated['device']);
        }

        $startDate = $validated['startDate'];
        $endDate = $validated['endDate'] ?? '9999-12-30';

        return $query
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->get()
            ->toArray();

    }
}
