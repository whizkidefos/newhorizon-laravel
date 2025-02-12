<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'super-admin',
            'admin',
            'healthcare_worker',
            'employer',
            'trainer'
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Create permissions
        $permissions = [
            'manage_users',
            'manage_roles',
            'manage_shifts',
            'manage_courses',
            'view_reports',
            'manage_settings',
            'manage_trainings',
            'manage_certifications',
            'manage_documents'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign all permissions to super-admin and admin roles
        $superAdminRole = Role::findByName('super-admin');
        $adminRole = Role::findByName('admin');
        
        $superAdminRole->syncPermissions($permissions);
        $adminRole->syncPermissions($permissions);

        // Assign specific permissions to other roles
        $healthcareWorkerRole = Role::findByName('healthcare_worker');
        $healthcareWorkerRole->syncPermissions([
            'view_reports',
            'manage_documents'
        ]);

        $employerRole = Role::findByName('employer');
        $employerRole->syncPermissions([
            'manage_shifts',
            'view_reports',
            'manage_documents'
        ]);

        $trainerRole = Role::findByName('trainer');
        $trainerRole->syncPermissions([
            'manage_trainings',
            'manage_certifications',
            'view_reports'
        ]);
    }
}
