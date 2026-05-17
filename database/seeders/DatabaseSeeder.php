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
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'djpangoro@admin.com',
            'password' => bcrypt('adminpassword'),
            'is_admin' => 1,
        ]);

        $users = User::factory(149)->create();

        $tags = Tag::factory(20)->create();

        Car::factory(250)->create()->each(function ($car) use ($users, $tags) {

            $car->user_id = $users->random()->id;
            $car->save();

            $car->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')->toArray()
            );
        });
    }
}