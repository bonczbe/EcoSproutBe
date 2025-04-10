<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Kek Elek',
            'email' => 'admin@admin.admin',
            'password' => Hash::make('123456'),
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);
        User::factory(10)->create();
    }
}
