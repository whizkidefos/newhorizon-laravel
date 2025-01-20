<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Create roles if they don't exist
        $roles = ['super-admin', 'admin', 'healthcare-professional'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Create Super Admin
        $superAdmin = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@newhorizon.com',
            'password' => Hash::make('Admin123!@#'),
            'mobile_phone' => '07700900000',
            'username' => 'superadmin',
            'job_role' => 'registered_nurse',  // Required field
            'dob' => '1990-01-01',            // Required field
            'gender' => 'male',               // Required field
            'postcode' => 'CH1 1AA',          // Required field
            'address' => '123 Admin Street',   // Required field
            'country' => 'UK',                // Required field
            'ni_number' => 'AA123456A',       // Required field
            'nationality' => 'UK',            // Required field
            'is_admin' => true,
            'admin_level' => 'super_admin',
            'admin_created_at' => now(),
            'email_verified_at' => now(),
        ]);

        $superAdmin->assignRole('super-admin');
    }
}