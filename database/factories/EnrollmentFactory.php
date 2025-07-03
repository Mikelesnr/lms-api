<?php

namespace Database\Factories;

use App\Models\Enrollment;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::where('role', \App\Enums\UserRole::Student)->inRandomOrder()->first()?->id,
            'course_id' => Course::inRandomOrder()->first()?->id,
            'started_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'completed_at' => null, // we can randomize completion later
        ];
    }
}
