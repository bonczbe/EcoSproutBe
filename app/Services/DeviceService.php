<?php

namespace App\Services;

use App\Repositories\DeviceRepository;

class DeviceService
{
    public function __construct(private DeviceRepository $deviceRepository) {}

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
        return $this->deviceRepository->storeDevice($data);
    }
}
