<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProfileDetail;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@newhorizon.com',
            'mobile_number' => '07700900001',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'job_role' => 'Administrator',
            'date_of_birth' => '1985-01-01',
            'gender' => 'other',
            'national_insurance_number' => 'ZZ123456A',
            'nationality' => 'UK',
            'right_to_work_uk' => true,
            'has_enhanced_dbs' => true,
            'email_verified_at' => now(),
        ]);

        ProfileDetail::create([
            'user_id' => $admin->id,
            'address_line_1' => '1 Admin Street',
            'city' => 'London',
            'postcode' => 'SW1A 1AA',
            'country' => 'UK',
        ]);

        $admin->assignRole('admin');

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
            'national_insurance_number' => 'AB123456C',
            'nationality' => 'UK',
            'right_to_work_uk' => true,
            'has_enhanced_dbs' => true,
            'email_verified_at' => now(),
        ]);

        ProfileDetail::create([
            'user_id' => $regularUser->id,
            'address_line_1' => '123 Main St',
            'city' => 'Chester',
            'postcode' => 'CH1 1AA',
            'country' => 'UK',
        ]);

        $regularUser->assignRole('employee');

        // Create some additional employees
        $users = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@example.com',
                'mobile_number' => '07700900003',
                'username' => 'johndoe',
                'password' => Hash::make('password'),
                'job_role' => 'Healthcare Assistant',
                'date_of_birth' => '1992-05-15',
                'gender' => 'male',
                'national_insurance_number' => 'CD123456D',
                'nationality' => 'UK',
                'right_to_work_uk' => true,
                'has_enhanced_dbs' => true,
                'email_verified_at' => now(),
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane@example.com',
                'mobile_number' => '07700900004',
                'username' => 'janesmith',
                'password' => Hash::make('password'),
                'job_role' => 'Support Worker',
                'date_of_birth' => '1988-09-20',
                'gender' => 'female',
                'national_insurance_number' => 'EF123456E',
                'nationality' => 'UK',
                'right_to_work_uk' => true,
                'has_enhanced_dbs' => true,
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);
            
            ProfileDetail::create([
                'user_id' => $user->id,
                'address_line_1' => fake()->streetAddress(),
                'city' => fake()->city(),
                'postcode' => fake()->postcode(),
                'country' => 'UK',
            ]);

            $user->assignRole('employee');
        }
    }
}