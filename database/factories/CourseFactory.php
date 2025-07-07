<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    const categories = [
        'Development',
        'Business',
        'Finance & Accounting',
        'IT & Software',
        'Office Productivity',
        'Personal Development',
        'Design',
        'Marketing',
        'Lifestyle',
        'Photography & Video',
        'Health & Fitness',
        'Music',
        'Teaching & Academics',
        'Language Learning',
        'Engineering & Architecture',
        'Data Science',
        'Cybersecurity',
        'Project Management',
        'Game Development',
        'AI & Machine Learning',
    ];

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(3),
            'category' => $this->faker->randomElement(self::categories),
            'is_published' => true,
            'published_at' => now(),
        ];
    }
}
