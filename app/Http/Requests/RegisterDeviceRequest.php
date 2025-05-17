<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterDeviceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'location' => 'required|',
            'city' => '',
            'is_on' => 'required|boolean',
            'is_inside' => 'required|boolean',

        ];
    }
}
