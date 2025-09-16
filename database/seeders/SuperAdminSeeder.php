<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'lppmumn.baduy@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('Baduyofficial2025'),
                'role' => 'superadmin',
                'email_verified_at' => now(),
            ]
        );
    }
}