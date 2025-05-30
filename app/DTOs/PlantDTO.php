<?php

namespace App\DTOs;

class PlantDTO
{
    public static function fromApiResponse(array $data): array
    {
        return [
            'name_en' => $data['common_name'] ?? '',
            'name_hu' => $data['name_hu'] ?? '',
            'name_botanical' => is_array($data['scientific_name']) ? $data['scientific_name'][0] : $data['scientific_name'] ?? '',
            'family' => $data['family'],
            'family_hu' => $data['family_hu'],
            'default_image' => $data['default_image']['original_url'] ?? '',
            'species_epithet' => $data['species_epithet'] ?? '',
            'genus' => $data['genus'] ?? '',
            'plant_type_id' => $data['plant_type_id'] ?? null,
        ];
    }
}
