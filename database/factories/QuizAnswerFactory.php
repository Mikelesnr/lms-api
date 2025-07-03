<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\QuizAnswer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizAnswer>
 */
class QuizAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = QuizAnswer::class;

    public function definition(): array
    {
        return [
            'answer_text' => fake()->sentence(4),
            'is_correct' => false,
            // 'question_id' will be injected via the seeder
        ];
    }
}
