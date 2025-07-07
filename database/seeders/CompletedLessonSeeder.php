<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompletedLesson;
use App\Models\Lesson;
use App\Models\Enrollment;

class CompletedLessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $enrollments = Enrollment::all();

        foreach ($enrollments as $enrollment) {
            $lessons = Lesson::where('course_id', $enrollment->course_id)->get();

            // Simulate the student completing 1–3 random lessons
            $completed = $lessons->random(rand(1, min(3, $lessons->count())));

            foreach ($completed as $lesson) {
                CompletedLesson::firstOrCreate([
                    'user_id' => $enrollment->user_id,
                    'lesson_id' => $lesson->id,
                ], [
                    'grade' => rand(50, 100),
                ]);
            }
        }
    }
}
