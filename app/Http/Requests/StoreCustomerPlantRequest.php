<?php

namespace App\Http\Requests;

use App\Models\PlantType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class StoreCustomerPlantRequest extends FormRequest
{
    /**
     * Summary of DIRT_TYPES
     *
     * @var array
     */
    private const DIRT_TYPES = [
        'all_purpose',
        'cactus_succulent',
        'orchid',
        'seed_starting',
        'african_violet',
        'indoor',
        'moisture_control',
        'peat_based',
        'coco_coir',
        'compost_rich',
        'bonsai',
        'aquatic',
        'perlite',
        'vermiculite',
        'sandy_loam',
    ];

    /**
     * Summary of rules
     *
     * @return array{
     * device: string,
     * dritType: array<string|\Illuminate\Validation\Rules\In>,
     * family: string,
     * maxMoist: string,
     * minMoist: string,
     * name: string,
     * plantName: string,
     * plantType: array<string|\Illuminate\Validation\Rules\In>,
     * potSize: string}
     */
    public function rules(): array
    {
        $plantTypes = Cache::remember('plant_types', 3600, function () {
            return PlantType::pluck('type')->toArray();
        });

        return [
            'plantName' => 'required|string',
            'family' => 'required|string',
            'device' => 'required|integer',
            'potSize' => 'required|integer|min:0',
            'maxMoist' => 'nullable|integer|max:100',
            'plantImage' => 'nullable|file',
            'minMoist' => 'nullable|integer|min:0',
            'dritType' => ['required', 'string', Rule::in(self::DIRT_TYPES)],
            'name' => 'required|string',
            'plantType' => ['required', 'string', Rule::in($plantTypes)],
        ];
    }
}
