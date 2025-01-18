<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@newhorizon.com',
            'password' => Hash::make('admin123!@#'),
            'mobile_phone' => '07700900000',
            'username' => 'superadmin',
            'is_admin' => true,
            'admin_level' => 'super_admin',
            'admin_created_at' => now(),
            'email_verified_at' => now(),
            // Add other required fields
        ]);
    }
}