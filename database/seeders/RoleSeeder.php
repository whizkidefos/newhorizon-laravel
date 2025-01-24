<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $roles = [
            'admin' => [
                'manage users',
                'manage roles',
                'manage courses',
                'manage shifts',
                'view reports'
            ],
            'employee' => [
                'view profile',
                'edit profile',
                'view courses',
                'enroll courses',
                'view shifts',
                'book shifts'
            ],
        ];

        foreach ($roles as $role => $permissions) {
            $roleModel = Role::create(['name' => $role]);

            foreach ($permissions as $permission) {
                $permissionModel = Permission::firstOrCreate(['name' => $permission]);
                $roleModel->givePermissionTo($permissionModel);
            }
        }
    }
}
