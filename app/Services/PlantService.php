<?php

namespace App\Services;

use App\DTOs\PlantDTO;
use App\Models\Plant;
use App\Repositories\PlantRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PlantService
{
    protected PlantRepository $plantRepository;

    public function __construct(PlantRepository $plantRepository)
    {
        $this->plantRepository = $plantRepository;
    }

    public function fetchAndStorePlant()
    {
        Log::info('Started to fetch the daily 100 plants...');

        $plants = $this->fetchPlants();

        try {
            $this->plantRepository->upsertPlantData($plants);
        } catch (\Exception $e) {
            Log::error(''.$e->getMessage());
        }
    }

    protected function fetchPlants(): array
    {
        $perPage = 30;
        $maxRequests = 100;
        $plantData = [];

        for ($i = 0; $i < $maxRequests; $i++) {

            $currentPage = floor((Plant::distinct('name_botanical')->count()+count($plantData)) / $perPage) + 1;
            $response = Http::get('https://perenual.com/api/v2/species-list', [
                'key' => env('PERENUAL_COM'),
                'page' => $currentPage,
            ]);

            if ($response->successful()) {

                $data = $response->json();
                if ($data['data']) {
                    $currentPage = $data['current_page'] ?? 1;
                    $lastPage = $data['last_page'] ?? 1;

                    Log::info("Fetched Page: $currentPage / $lastPage\n");

                    if ($currentPage >= $lastPage) {
                        Log::info("Reached the last page. Stopping...\n");
                        break;
                    }

                    foreach ($data['data'] as $plant) {

                        $plantData[] = PlantDTO::fromApiResponse($plant);
                    }

                } else {
                    Log::error('Failed to fetch data. HTTP Status: '.$response->status()."\n");
                }

                sleep(6);

            } else {
                $i = $maxRequests;
                Log::error('Reached the daily limit!');
            }
        }

        return $plantData;
    }
}
