<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Enums\UserRole;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Named test users with known roles and credentials
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => UserRole::Admin,
        ]);

        User::factory()->create([
            'name' => 'Instructor User',
            'email' => 'instructor@example.com',
            'role' => UserRole::Instructor,
        ]);

        User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'role' => UserRole::Student,
        ]);

        // Extra users for broader testing
        User::factory(5)->create(['role' => UserRole::Instructor]);
        User::factory(10)->create(['role' => UserRole::Student]);
        User::factory(2)->create(['role' => UserRole::Admin]);
    }
}
