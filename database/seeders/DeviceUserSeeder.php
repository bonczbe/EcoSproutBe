<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\User;
use Illuminate\Database\Seeder;

class DeviceUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $devices = Device::all();

        foreach ($users as $user) {
            $user->devices()->attach($devices->random(rand(1, 3))->pluck('id')->toArray());
        }
    }
}
