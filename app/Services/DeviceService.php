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

    public function getDevicesByUser($user)
    {
        $devices = $this->deviceRepository->getDevicesByUser($user);
        $cities = $devices->pluck('city')->unique();
        $weathers = $this->weatherRepository->getLastWeatherForCities($cities);

        return [
            'bdevices' => $this->deviceRepository->getDevicesByUser($user),
            'weathers' => $weathers,
        ];
    }
}
