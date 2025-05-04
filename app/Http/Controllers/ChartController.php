<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeatherChartRequest;
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
}
