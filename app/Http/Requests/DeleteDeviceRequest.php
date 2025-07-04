<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteDeviceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|integer',
        ];
    }
}
