<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\QuizQuestion;

class QuizQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Quiz::all()->each(function ($quiz) {
            QuizQuestion::factory(rand(3, 5))->create([
                'quiz_id' => $quiz->id,
            ]);
        });
    }
}
