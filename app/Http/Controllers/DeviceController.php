<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteDeviceRequest;
use App\Http\Requests\RegisterDeviceRequest;
use App\Http\Requests\UpdateDeviceRequest;
use App\Models\Device;
use App\Services\DeviceService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DeviceController extends Controller
{
    public function __construct(private readonly DeviceService $deviceService) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user('web');

        return Inertia::render('devices', $this->deviceService->getDeviceWithWeatherByUser($user));
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
    public function store(RegisterDeviceRequest $request)
    {
        $device = $this->deviceService->storeNewDevice($request->validated());

        return ($device) ? response($device, 200) : response('Unprocessable Content', 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Device $device)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDeviceRequest $request)
    {
        $validate = $request->validated();
        $updated = $this->deviceService->updateDeviceById($validate['id'], $validate);
        if ($updated === -1) {
            return response('Unprocessable Content', 422);
        }

        return response($updated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteDeviceRequest $request)
    {
        $validate = $request->validated();
        $updated = $this->deviceService->deleteDeviceById($validate['id']);
        if ($updated === -1) {
            return response('Unprocessable Content', 422);
        }

        return response($updated);
    }
}
