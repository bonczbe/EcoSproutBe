<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterDeviceRequest;
use App\Models\Device;
use App\Services\DeviceService;
use Illuminate\Http\Request;
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

        return Inertia::render('devices', $this->deviceService->getDevicesByUser($user));
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

        return ($device) ? response($device, 201) : response('Unprocessable Content', 422);
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
    public function update(RegisterDeviceRequest $request, Device $device)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        //
    }
}
