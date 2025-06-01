<?php

namespace App\Services;

use App\Repositories\DeviceRepository;
use App\Repositories\WeatherRepository;
use Illuminate\Support\Facades\Auth;

class DeviceService
{
    public function __construct(private DeviceRepository $deviceRepository, private WeatherRepository $weatherRepository) {}

    public function getDeviceHistoryDataByDate($data, $user): array
    {
        $startDate = $data['startDate'];
        $endDate = $data['endDate'] ?? '9999-12-30';

        if ($data['device'] != -1) {
            return $this->deviceRepository->getDeviceHistoriesByDate($startDate, $endDate, $data['device'], $user);
        } else {
            return $this->deviceRepository->getDevicesHistoriesByDate($startDate, $endDate, $user);
        }
    }

    public function storeNewDevice($data)
    {
        $user = Auth::user('web');
        $device = $this->deviceRepository->storeDevice($data, $user);
        $device->users()->syncWithoutDetaching($user->id);

        return $device;
    }

    public function getDeviceWithWeatherByUser($user){
        $devices = $this->getDevicesByUser($user);
        $cities = $devices->pluck('city')->unique();
        $weathers = $this->weatherRepository->getLastWeatherForCities($cities);

        return [
            'bdevices' => $this->deviceRepository->getDevicesByUser($user),
            'weathers' => $weathers,
        ];
    }

    public function getDevicesByUser($user)
    {
        return $this->deviceRepository->getDevicesByUser($user);
    }

    public function updateDeviceById($id, $data)
    {
        $user = Auth::user('web');
        $device = $this->deviceRepository->getDeviceById($id, $user);

        if (! $device) {
            return -1;
        }

        $status = $this->deviceRepository->updateDevice($device, $data);

        return [
            'status' => $status,
        ];
    }

    public function deleteDeviceById($id)
    {
        $user = Auth::user('web');
        $device = $this->deviceRepository->getDeviceById($id, $user);

        if (! $device) {
            return -1;
        }

        $status = $this->deviceRepository->destroyDevice($device);

        return [
            'status' => $status,
        ];
    }
}
