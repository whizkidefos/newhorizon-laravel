<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProfileDetail;
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
        $superAdmin = User::whereEmail('admin@newhorizon.com')->first();
        
        if (!$superAdmin) {
            $superAdmin = User::create([
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@newhorizon.com',
                'password' => Hash::make('Admin123!@#'),
                'mobile_number' => '07700900001',
                'username' => 'superadmin',
                'job_role' => 'Registered Nurse',
                'date_of_birth' => '1990-01-01',
                'gender' => 'male',
                'national_insurance_number' => 'AA123456A',
                'nationality' => 'UK',
                'right_to_work_uk' => true,
                'has_enhanced_dbs' => true,
                'email_verified_at' => now(),
                'is_admin' => true,
            ]);

            // Create profile details
            ProfileDetail::create([
                'user_id' => $superAdmin->id,
                'address_line_1' => '123 Admin Street',
                'city' => 'Chester',
                'postcode' => 'CH1 1AA',
                'country' => 'UK',
            ]);

            // Assign admin role
            $superAdmin->assignRole('admin');
        }
    }
}