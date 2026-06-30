<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            //Employee
            'employee.view',
            'employee.create',
            'employee.delete',
            'employee.update',

            //Department
            'department.view',
            'department.create',
            'department.update',
            'department.delete',
        ];

        foreach($permissions as $permission){
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate([
                'name' => 'Admin'
        ]);

        $hr = Role::firstOrCreate([
                'name' => 'HR'
        ]);

        $manager = Role::firstOrCreate([
                'name' => 'Manager'
        ]);

        $employee = Role::firstOrCreate([
                'name' => 'Employee'
        ]);

        $admin -> givePermissionTo(Permission::all());

        $hr -> givePermissionTo([
            'employee.view',
            'employee.create',
            'employee.update',
            'employee.delete',
        ]);

        $employee-> givePermissionTo([
            'employee.update',
            'employee.view',
        ]);

        $user = User::where('email', 'jeremiahmollag@gmail.com')->first();

        if($user){
            $user->assignRole('Admin');
        }
       
    }
}
