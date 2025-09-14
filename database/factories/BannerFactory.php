<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Banner>
 */
class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 'title' => fake()->words(3 , true),
            // 'url' => fake()->words(3 , true),
            // 'image' => fake()->words(3 , true),
            // 'status' => fake()->randomElement(['active' , 'inactive']),
        ];
    }
}
