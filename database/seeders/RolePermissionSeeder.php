<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles
        $admin = Role::create(['name' => 'admin']);
        $staff = Role::create(['name' => 'staff']);

        // Permissions
        $createTask = Permission::create(['name' => 'create_task']);
        $assignTask = Permission::create(['name' => 'assign_task']);
        $viewTask = Permission::create(['name' => 'view_task']);
        $updateTask = Permission::create(['name' => 'update_task']);

        // Assign permissions to roles
        $admin->givePermissionTo([
            $createTask,
            $assignTask,
            $viewTask,
            $updateTask
        ]);

        $staff->givePermissionTo([
            $viewTask,
            $updateTask
        ]);
    }
}
