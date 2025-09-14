<?php

namespace Database\Factories;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $title = fake()->words(3 , true),
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1, 999),
            'description' => fake()->sentence('6' , true),
            'stock' => fake()->numberBetween(100 , 1000),
            'price' => fake()->randomFloat(2 , 1000 , 1000000),
            'status' => fake()->randomElement(['unseen', 'seen', 'approved']),
            'category_id' => Category::inRandomOrder()->first()->id,
            
        ];
    }
}
