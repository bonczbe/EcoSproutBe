<?php

namespace App\Console\Commands;

use App\Services\PlantService;
use Illuminate\Console\Command;

class GetPlants extends Command
{
    protected $signature = 'app:get-plants';

    protected $description = 'Fetch all the plants by 100 requests a day';

    protected PlantService $plantService;

    public function __construct(PlantService $plantService)
    {
        parent::__construct();
        $this->plantService = $plantService;
    }

    public function handle()
    {
        $this->plantService->fetchAndStorePlant();
    }
}
