<?php

namespace App\Http\Controllers;

use App\Models\CustomerPlant;
use App\Services\CustomerPlantService;
use App\Services\DeviceService;
use App\Services\PlantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CustomerPlantController extends Controller
{
    public function __construct(
        private readonly CustomerPlantService $customerPlantService,
        private readonly DeviceService $deviceService,
        private readonly PlantService $plantService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user('web');

        return Inertia::render('plants', [
            'plants' => $this->customerPlantService->getDevicesByUser($user),
            'devices' => $this->deviceService->getDevicesByUser($user),
            'plantFamilies' => $this->plantService->getPlantFamilies(),
        ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerPlant $customerPlant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerPlant $customerPlant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerPlant $customerPlant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerPlant $customerPlant)
    {
        //
    }
}
