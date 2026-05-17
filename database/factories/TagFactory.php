<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    private static array $tags = [
        ['name' => 'SUV', 'color' => 'primary'],
        ['name' => 'Sedan', 'color' => 'success'],
        ['name' => 'Hatchback', 'color' => 'warning'],
        ['name' => 'Cabrio', 'color' => 'danger'],
        ['name' => 'Elektrisch', 'color' => 'info'],
        ['name' => 'Hybride', 'color' => 'primary'],
        ['name' => 'Sport', 'color' => 'danger'],
        ['name' => 'Diesel', 'color' => 'secondary'],
        ['name' => 'Benzine', 'color' => 'success'],
        ['name' => 'Automaat', 'color' => 'info'],
        ['name' => 'Handgeschakeld', 'color' => 'warning'],
        ['name' => '4x4', 'color' => 'primary'],
        ['name' => 'Stationwagon', 'color' => 'success'],
        ['name' => 'Compact', 'color' => 'info'],
        ['name' => 'Luxury', 'color' => 'warning'],
        ['name' => 'Offroad', 'color' => 'danger'],
        ['name' => 'Pick-up', 'color' => 'primary'],
        ['name' => 'Coupe', 'color' => 'secondary'],
        ['name' => 'Youngtimer', 'color' => 'info'],
        ['name' => 'Oldtimer', 'color' => 'warning'],
    ];

    private static int $index = 0;

    public function definition(): array
    {
        $data = self::$tags[self::$index % count(self::$tags)];
        self::$index++;

        return $data;
    }
}