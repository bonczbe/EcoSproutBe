<?php

namespace App\Services;

use App\Repositories\CustomerPlantRepository;
use App\Repositories\PlantRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CustomerPlantService
{
    public function __construct(private readonly CustomerPlantRepository $customerPlantRepository, private readonly PlantRepository $plantRepository) {}

    public function getDevicesByUser($user)
    {
        return $this->customerPlantRepository->getAllCustomerPlantIdWithPlantNameForUser($user);
    }

    public function storeCustomerPlant(array $datas)
    {
        $user = Auth::user('web');
        $selectedPlant = $this->plantRepository->getPlantByNameEnFamily(
            $datas['plantName'],
            $datas['family']
        );

        $imagePath = null;

        if (isset($datas['plantImage']) && $datas['plantImage'] instanceof \Illuminate\Http\UploadedFile) {

            $extension = $datas['plantImage']->getClientOriginalExtension();
            $originalName = pathinfo($datas['plantImage']->getClientOriginalName(), PATHINFO_FILENAME);
            $sanitizedOriginalName = Str::slug($originalName);
            $sanitizedPlantName = Str::slug($datas['name']);
            $timestamp = Carbon::now()->format('Ymd_His');
            $userEmail = Str::slug($user->email);

            $baseFilename = "{$sanitizedPlantName}_{$sanitizedOriginalName}_{$timestamp}";
            $maxBaseLength = 100 - (strlen($extension) + 1);
            $shortenedBase = Str::limit($baseFilename, $maxBaseLength, '');

            $filename = "{$shortenedBase}.{$extension}";
            $path = "plant/{$userEmail}/{$filename}";

            $imagePath = $datas['plantImage']->storeAs('plant/' . $userEmail, $filename, 'public');
        }

        return $this->customerPlantRepository->store([
            'pot_size' => $datas['potSize'],
            'plant_img' => $imagePath ? asset(Storage::url($imagePath)) : null,
            'dirt_type' => $datas['dritType'],
            'name' => $datas['name'],
            'device_id' => $datas['device'],
            'plant_id' => $selectedPlant->id,
            'plant_type_id' => $datas['realPlantType'],
        ]);

    }
}
