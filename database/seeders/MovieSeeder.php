<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        $genres = Genre::all();

        Movie::factory(10)
            ->create()
            ->each(function ($movie) use ($genres) {
                $movie->genres()->attach($genres->random(rand(1, 3)));
            });
    }
}
