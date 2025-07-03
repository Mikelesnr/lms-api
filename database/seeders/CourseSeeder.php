<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Get all instructor users
        $instructors = User::where('role', \App\Enums\UserRole::Instructor)->get();

        foreach ($instructors as $instructor) {
            Course::factory(3)->create([
                'user_id' => $instructor->id,
            ]);
        }
    }
}
