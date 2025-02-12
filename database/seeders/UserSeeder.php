<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProfileDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    public function run()
    {
        Log::info('Starting UserSeeder...');

        // Create regular user
        $regularUser = User::create([
            'first_name' => 'Regular',
            'last_name' => 'User',
            'email' => 'user@newhorizon.com',
            'mobile_number' => '07700900002',
            'username' => 'regularuser',
            'password' => Hash::make('password'),
            'job_role' => 'Healthcare Assistant',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'national_insurance_number' => 'BB123456A',
            'nationality' => 'UK',
            'right_to_work_uk' => true,
            'has_enhanced_dbs' => true,
            'email_verified_at' => now(),
            'is_admin' => false,
        ]);

        Log::info('Created regular user', ['id' => $regularUser->id]);

        ProfileDetail::create([
            'user_id' => $regularUser->id,
            'address_line_1' => '2 Healthcare Street',
            'city' => 'Manchester',
            'postcode' => 'M1 1AA',
            'country' => 'UK',
        ]);

        $regularUser->assignRole('healthcare_worker');

        // Create some additional healthcare workers
        $users = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'mobile_number' => '07700900003',
                'username' => 'johndoe',
                'job_role' => 'Registered Nurse',
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane@example.com',
                'mobile_number' => '07700900004',
                'username' => 'janesmith',
                'job_role' => 'Healthcare Assistant',
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'email' => 'michael@example.com',
                'mobile_number' => '07700900005',
                'username' => 'michaelj',
                'job_role' => 'Senior Care Assistant',
            ],
            [
                'first_name' => 'Sarah',
                'last_name' => 'Williams',
                'email' => 'sarah@example.com',
                'mobile_number' => '07700900006',
                'username' => 'sarahw',
                'job_role' => 'Registered Nurse',
            ],
        ];

        foreach ($users as $userData) {
            try {
                $user = User::create(array_merge($userData, [
                    'password' => Hash::make('password'),
                    'date_of_birth' => '1990-01-01',
                    'gender' => 'other',
                    'national_insurance_number' => 'XX' . rand(100000, 999999) . 'X',
                    'nationality' => 'UK',
                    'right_to_work_uk' => true,
                    'has_enhanced_dbs' => true,
                    'email_verified_at' => now(),
                    'is_admin' => false,
                ]));

                Log::info('Created additional user', ['id' => $user->id, 'email' => $user->email]);

                ProfileDetail::create([
                    'user_id' => $user->id,
                    'address_line_1' => rand(1, 100) . ' Healthcare Street',
                    'city' => 'Manchester',
                    'postcode' => 'M' . rand(1, 20) . ' ' . rand(1, 9) . 'AA',
                    'country' => 'UK',
                ]);

                $user->assignRole('healthcare_worker');
            } catch (\Exception $e) {
                Log::error('Failed to create user', [
                    'error' => $e->getMessage(),
                    'userData' => $userData
                ]);
            }
        }

        Log::info('UserSeeder completed');
    }
}