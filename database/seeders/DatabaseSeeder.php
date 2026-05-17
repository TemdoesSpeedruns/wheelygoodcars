<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Car;
use App\Models\Tag;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 150 USERS
        $users = User::factory(150)->create();

        // 20 TAGS
        $tags = Tag::factory(20)->create();

        // 250 CARS
        $cars = Car::factory(250)->create([
            'user_id' => $users->random()->id,
        ]);

        foreach ($cars as $car) {
            $car->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}