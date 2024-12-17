<?php

namespace App\Services;

use App\Models\Genre;
use App\Models\Movie;
use App\Http\Resources\MovieResource;
use Illuminate\Http\JsonResponse;

class MovieService
{
  public function getAllMovies(int $page): JsonResponse
  {
    $movies = Movie::with('genres')->paginate(perPage: 10, page: $page);
    return response()->json(
      [
        'data' => MovieResource::collection($movies),
        'current_page' => $movies->currentPage(),
        'last_page' => $movies->lastPage()
      ]
    );
  }

  public function getMovieById(int $id): JsonResponse
  {
    $movie = Movie::with('genres')->findOrFail($id);
    return response()->json(new MovieResource($movie));
  }

  public function createMovie(array $validated): JsonResponse
  {
    $title = $validated['title'];
    $genres = $validated['genres'] ?? [];

    if (request()->hasFile('poster') && request()->file('poster')->isValid()) {
      $posterPath = request()->file('poster')->store('posters', 'public');
    } else {
      $posterPath = 'posters/default.jpg';
    }

    $movie = Movie::create([
      'title' => $title,
      'poster_path' => $posterPath,
      'is_published' => false,
    ]);

    if (!empty($genres)) {
      $genreIds = Genre::whereIn('name', $genres)->pluck('id');
      $movie->genres()->attach($genreIds);
    }

    return response()->json([
      'message' => 'Movie has been created!',
      'movie' => new MovieResource($movie->load('genres')),
    ], 201);
  }

  public function updateMovie(int $id, array $validated): JsonResponse
  {
    $movie = Movie::findOrFail($id);
    $movie->title = $validated['title'] ?? $movie->title;

    if (request()->hasFile('poster') && request()->file('poster')->isValid()) {
      if ($movie->poster_path && file_exists(storage_path('app/public/' . $movie->poster_path))) {
        unlink(storage_path('app/public/' . $movie->poster_path));
      }
      $movie->poster_path = request()->file('poster')->store('posters', 'public');
    }

    if (!empty($validated['genres'])) {
      $genreIds = Genre::whereIn('name', $validated['genres'])->pluck('id');
      $movie->genres()->sync($genreIds);
    }

    $movie->save();

    return response()->json([
      'message' => 'Movie has been updated!',
      'movie' => new MovieResource($movie->load('genres')),
    ]);
  }

  public function deleteMovie(int $id): JsonResponse
  {
    $movie = Movie::findOrFail($id);
    $movie->genres()->detach();
    $movie->delete();

    return response()->json([
      'message' => 'Movie has been deleted!',
    ]);
  }

  public function publishMovie(int $id): JsonResponse
  {
    $movie = Movie::findOrFail($id);
    $movie->is_published = true;
    $movie->save();

    return response()->json([
      'message' => 'Movie has been published!',
      'movie' => new MovieResource($movie),
    ]);
  }
}
