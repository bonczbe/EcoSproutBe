<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeviceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|integer',
            'name' => 'required|string',
            'location' => 'required|',
            'city' => 'required',
            'is_on' => 'required|boolean',
            'is_inside' => 'required|boolean',

        ];
    }
}
