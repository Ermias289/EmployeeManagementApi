<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 't@gmail.com',
        ]);

        Department::create([
            'name' => 'IT',
            'description' => 'Handles systems and software',
        ]);

        Department::create([
            'name' => 'HR',
            'description' => 'Manages employees',
        ]);

        $this->call([RolePermissionSeeder::class]);
    }
}
