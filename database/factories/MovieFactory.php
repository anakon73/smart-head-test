<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'is_published' => $this->faker->boolean(30),
            'poster_path' => 'posters/default.jpg',
        ];
    }
}
