<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement([
                'SUV',
                'Sedan',
                'Hatchback',
                'Cabrio',
                'Elektrisch',
                'Hybride',
                'Sport',
                'Diesel',
                'Benzine',
                'Automaat',
                'Handgeschakeld',
                '4x4'
            ]),
            'color' => fake()->randomElement([
                'primary',
                'success',
                'warning',
                'danger',
                'info'
            ]),
        ];
    }
}