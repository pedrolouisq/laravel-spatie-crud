<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage roles',
            'manage permissions',
            'manage users',
            'view tasks',
            'create tasks',
            'edit tasks',
            'delete tasks'
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // Create roles and assign permissions

        // Admin: has all permissions
        $roleAdmin = Role::findOrCreate('admin');
        $roleAdmin->givePermissionTo(Permission::all());

        // Manager: can create, edit and view tasks
        $roleManager = Role::findOrCreate('manager');
        $roleManager->givePermissionTo([
            'view tasks',
            'create tasks',
            'edit tasks'
        ]);

        // Viewer: can only view tasks
        $roleViewer = Role::findOrCreate('viewer');
        $roleViewer->givePermissionTo([
            'view tasks'
        ]);
    }
}
