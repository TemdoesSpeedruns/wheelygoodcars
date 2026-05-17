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
        User::factory(150)->create();
        Tag::factory(20)->create();
        Car::factory(250)->create()->each(function ($car) {
            $tags = Tag::inRandomOrder()
                ->take(rand(1, 3))
                ->pluck('id');

            $car->tags()->attach($tags);
        });
    }
}