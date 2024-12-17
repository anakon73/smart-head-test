<?php

namespace App\Services;

use App\Models\Genre;
use App\Http\Resources\GenreResource;
use App\Http\Resources\MovieResource;
use Illuminate\Http\JsonResponse;

class GenreService
{
  public function getAllGenres(): JsonResponse
  {
    $genres = Genre::all();
    return response()->json(GenreResource::collection($genres));
  }

  public function getGenreWithMovies(int $id, int $page): JsonResponse
  {
    $genre = Genre::findOrFail($id);

    $movies = $genre->movies()->paginate(10);

    return response()->json([
      'genre' => new GenreResource($genre),
      'movies' => [
        'data' => MovieResource::collection($movies),
        'current_page' => $movies->currentPage(),
        'last_page' => $movies->lastPage()
      ],
    ]);
  }

  public function createGenre(array $validated): JsonResponse
  {
    $genre = Genre::create([
      'name' => $validated['name'],
    ]);

    return response()->json([
      'message' => 'Genre has been created!',
      'genre' => $genre,
    ], 201);
  }

  public function updateGenre(int $id, array $validated): JsonResponse
  {
    $genre = Genre::findOrFail($id);
    $genre->name = $validated['name'];
    $genre->save();

    return response()->json([
      'message' => 'Genre has been updated!',
      'genre' => $genre,
    ]);
  }

  public function deleteGenre(int $id): JsonResponse
  {
    $genre = Genre::findOrFail($id);
    $genre->movies()->detach();
    $genre->delete();

    return response()->json([
      'message' => 'Genre has been deleted!',
    ]);
  }
}
