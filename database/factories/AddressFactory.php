<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
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
            'title' => fake()->words(3 , true),
            'recipient_name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'postal_code' => fake()->postcode(),
            'province' => fake()->state(),
            'city' => fake()->city(),
            'address_line' => fake()->address(),
            'building_number' => fake()->numberBetween(1 , 500),
            'unit_number' => fake()->numberBetween(1 , 30),
            // 'is_default' => fake()->random,
        ];
    }
}
