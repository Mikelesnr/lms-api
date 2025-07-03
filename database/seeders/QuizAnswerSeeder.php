<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\QuizQuestion;
use App\Models\QuizAnswer;

class QuizAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        QuizQuestion::with('answers')->get()->each(function ($question) {
            // Avoid reseeding if already answered
            if ($question->answers->count()) return;

            // Create 3 incorrect answers
            QuizAnswer::factory(3)->create([
                'question_id' => $question->id,
                'is_correct' => false,
            ]);

            // Create 1 correct answer
            QuizAnswer::factory()->create([
                'question_id' => $question->id,
                'is_correct' => true,
                'answer_text' => 'Correct answer: ' . fake()->words(3, true),
            ]);
        });
    }
}
