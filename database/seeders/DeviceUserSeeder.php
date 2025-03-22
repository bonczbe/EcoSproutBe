<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Device;

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
