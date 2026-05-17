<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class CarFactory extends Factory
{
   public function definition(): array
    {
    $brands = [
        'Volkswagen' => ['Golf', 'Polo', 'Tiguan'],
        'BMW' => ['1 Serie', '3 Serie', 'X5'],
        'Audi' => ['A3', 'A4', 'Q5'],
        'Tesla' => ['Model 3', 'Model S', 'Model X'],
        'Ford' => ['Focus', 'Fiesta', 'Mustang'],
        'Toyota' => ['Yaris', 'Corolla', 'Prius'],
        'Mercedes' => ['A-Klasse', 'C-Klasse', 'GLA'],
        'Honda' => ['Civic', 'Jazz', 'CR-V'],
        'Nissan' => ['Micra', 'Qashqai', 'Juke'],
        'Hyundai' => ['i10', 'i20', 'Tucson'],
        'Opel' => ['Corsa', 'Astra', 'Insignia'],
        'Seat' => ['Ibiza', 'Leon', 'Arona'],
        'Renault' => ['Clio', 'Megane', 'Captur'],
    ];

    $brand = fake()->randomElement(array_keys($brands));

    return [
        'user_id' => User::inRandomOrder()->first()->id,

        'license_plate' => strtoupper(fake()->bothify('??-###-?')),

        'brand' => $brand,

        'model' => fake()->randomElement($brands[$brand]),

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