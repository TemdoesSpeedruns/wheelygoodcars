<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class CarFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'license_plate' => strtoupper(fake()->bothify('??-###-?')),
            'brand' => fake()->randomElement(['BMW','Audi','Tesla','Toyota','Ford','Volkswagen','Mercedes','Honda','Nissan','Hyundai']),
            'model' => fake()->word(),
            'price' => fake()->randomFloat(2, 5000, 95000),
            'mileage' => fake()->numberBetween(0, 300000),
            'seats' => fake()->randomElement([2,4,5,7]),
            'doors' => fake()->randomElement([2,3,4,5]),
            'production_year' => fake()->numberBetween(2000, 2025),
            'weight' => fake()->numberBetween(900, 2500),
            'color' => fake()->safeColorName(),
            'image' => null,
            'sold_at' => null,
            'views' => fake()->numberBetween(0, 500),
        ];
    }
}