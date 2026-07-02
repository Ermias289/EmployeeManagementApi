<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // 🔥 MUST BE INSIDE run()
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'employee.view',
            'employee.create',
            'employee.update',
            'employee.delete',

            'department.view',
            'department.create',
            'department.update',
            'department.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $hr = Role::firstOrCreate(['name' => 'HR']);
        $manager = Role::firstOrCreate(['name' => 'Manager']);
        $employee = Role::firstOrCreate(['name' => 'Employee']);

        $hr->syncPermissions([
            'employee.view',
            'employee.create',
            'employee.update',
        ]);

        $employee->syncPermissions([
            'employee.view',
        ]);

        // assign role safely
        $user = User::where('email', 'jeremiahmollag@gmail.com')->first();

        if ($user) {
            $user->syncRoles(['Admin']);
        }

        $admin = Role::firstOrCreate(['name' => 'Admin']);

        // ALWAYS sync all permissions to admin
        $admin->syncPermissions(Permission::all());
    }
}