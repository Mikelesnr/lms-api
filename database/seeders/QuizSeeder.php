<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lesson;
use App\Models\Quiz;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add a quiz to ~70% of lessons
        Lesson::all()->each(function ($lesson) {
            if (rand(0, 1)) {
                Quiz::factory()->create([
                    'lesson_id' => $lesson->id,
                ]);
            }
        });
    }
}
