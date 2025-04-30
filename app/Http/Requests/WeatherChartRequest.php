<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeatherChartRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'city' => 'required|string',
            'startDate' => 'required|date',
            'endDate' => 'nullable|date',
        ];
    }
}
