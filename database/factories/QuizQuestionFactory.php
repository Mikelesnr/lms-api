<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\QuizQuestion;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuizQuestion>
 */
class QuizQuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuizQuestion::class;

    public function definition(): array
    {
        return [
            'question_text' => fake()->sentence(8),
            'order' => fake()->numberBetween(1, 10),
            // 'quiz_id' will be assigned in the seeder
        ];
    }
}
