<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Enums\UserRole;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = User::where('role', UserRole::Student)->get();
        $courses = Course::all();

        foreach ($students as $student) {
            // Enroll each student in 2–4 random courses
            $randomCourses = $courses->random(rand(2, 4));

            foreach ($randomCourses as $course) {
                Enrollment::firstOrCreate([
                    'user_id' => $student->id,
                    'course_id' => $course->id,
                ], [
                    'started_at' => now()->subDays(rand(1, 30)),
                    'completed_at' => rand(0, 0) ? now()->subDays(rand(0, 10)) : null,
                ]);
            }
        }
    }
}
