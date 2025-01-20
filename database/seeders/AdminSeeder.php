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
        $superAdmin = User::whereEmail('admin@newhorizon.com')->first();
        
        if (!$superAdmin) {
            $superAdmin = User::create([
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@newhorizon.com',
                'password' => Hash::make('Admin123!@#'),
                'mobile_phone' => '07700900001',
                'username' => 'superadmin',
                'job_role' => 'registered_nurse',
                'dob' => '1990-01-01',
                'gender' => 'male',
                'postcode' => 'CH1 1AA',
                'address' => '123 Admin Street',
                'country' => 'UK',
                'ni_number' => 'AA123456A',
                'nationality' => 'UK',
                'email_verified_at' => now(),
            ]);
        }

        // Make sure the user has the super-admin role
        $superAdmin->syncRoles(['super-admin']);
    }
}