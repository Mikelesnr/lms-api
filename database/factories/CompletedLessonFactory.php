<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\CompletedLesson;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompletedLesson>
 */
class CompletedLessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = CompletedLesson::class;

    public function definition(): array
    {
        return [
            'user_id' => null,    // set in seeder
            'lesson_id' => null,  // set in seeder
        ];
    }
}
