<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state for multi-language user registration.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $languages = ['English', 'Hindi', 'Gujarati', 'Spanish', 'French'];

        return [
            'name' => fake()->name(),
            'age' => fake()->numberBetween(18, 80),
            'location' => fake()->city(),
            'selected_language' => fake()->randomElement($languages),
        ];
    }
}
