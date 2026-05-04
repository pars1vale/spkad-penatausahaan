<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cache dulu
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Definisi permissions
        $permissions = [
            // User management
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',

            // Role management
            'role.view',
            'role.create',
            'role.edit',
            'role.delete',
        ];

        // Buat semua permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat roles
        $superadmin = Role::firstOrCreate(['name' => 'superadmin']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $operator = Role::firstOrCreate(['name' => 'operator']);

        // Superadmin dapat semua permission
        $superadmin->syncPermissions(Permission::all());

        // Admin dapat manage user tapi tidak bisa manage role
        $admin->syncPermissions([
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',
        ]);

        // Operator hanya bisa view
        $operator->syncPermissions([
            'user.view',
        ]);
    }
}
