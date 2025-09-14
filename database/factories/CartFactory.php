<?php

namespace Database\Factories;
use App\Models\User;
use App\Models\Product;
use App\Models\Color;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'product_id' => Product::inRandomOrder()->first()->id,
            'quantity' => fake()->randomDigit(),
            'options' => null,
            // 'options' => [
            //     'color' => Color::inRandomOrder()->first()?->name ?? 'red', // نام رنگ از جدول colors
            //     'warranty' => $this->faker->randomElement(['1 year', '2 years', '3 years']),
            //     'gift_wrap' => $this->faker->boolean(), // true/false
            // ],

            
        ];
    }
}
