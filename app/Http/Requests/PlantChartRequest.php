<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlantChartRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'plant' => 'required|integer',
            'startDate' => 'required|date',
            'endDate' => 'nullable|date',
        ];
    }
}
