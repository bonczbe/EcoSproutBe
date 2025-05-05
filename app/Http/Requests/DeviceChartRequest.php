<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeviceChartRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'device' => 'required|integer',
            'startDate' => 'required|date',
            'endDate' => 'nullable|date',
        ];
    }
}
