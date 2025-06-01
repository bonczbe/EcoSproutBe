<?php

namespace App\Services;

use App\Repositories\CustomerPlantRepository;

class CustomerPlantService
{
    protected CustomerPlantRepository $customerPlantRepository;

    public function __construct(CustomerPlantRepository $customerPlantRepository)
    {
        $this->customerPlantRepository = $customerPlantRepository;
    }

    public function getDevicesByUser($user)
    {
        return $this->customerPlantRepository->getAllCustomerPlantIdWithPlantNameForUser($user);
    }
}
