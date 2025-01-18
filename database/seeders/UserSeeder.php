<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin role
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        // Create admin user
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@newhorizon.com',
            'mobile_phone' => '07700900000',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'job_role' => 'registered_nurse',
            'dob' => '1990-01-01',
            'gender' => 'male',
            'postcode' => 'CH1 1AA',
            'address' => '123 Main St',
            'country' => 'UK',
            'ni_number' => 'AB123456C',
            'nationality' => 'UK',
            'email_verified_at' => now(),
        ]);

        $admin->assignRole('admin');

        // Create some regular users
        $users = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'job_role' => 'healthcare_assistant',
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane@example.com',
                'job_role' => 'support_worker',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'first_name' => $userData['first_name'],
                'last_name' => $userData['last_name'],
                'email' => $userData['email'],
                'mobile_phone' => '07700' . rand(100000, 999999),
                'username' => strtolower($userData['first_name'] . $userData['last_name']),
                'password' => Hash::make('password'),
                'job_role' => $userData['job_role'],
                'dob' => '1990-01-01',
                'gender' => 'male',
                'postcode' => 'CH1 1AA',
                'address' => '123 Main St',
                'country' => 'UK',
                'ni_number' => 'AB' . rand(100000, 999999) . 'C',
                'nationality' => 'UK',
                'email_verified_at' => now(),
            ]);

            $user->assignRole('user');
        }
    }
}