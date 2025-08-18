<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage owners']);
        Permission::create(['name' => 'manage roles']);

        // Create roles and assign created permissions
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo(['manage users', 'manage owners', 'manage roles']);

        $roleUser = Role::create(['name' => 'user']);
        $roleUser->givePermissionTo(['manage roles']); // Example: regular users can only view dashboard

        // Assign admin role to a user (e.g., the first user created)
        $user = \App\Models\User::find(1); // Assuming user with ID 1 exists
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
