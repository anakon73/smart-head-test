<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGenreRequest;
use App\Http\Requests\UpdateGenreRequest;
use App\Services\GenreService;
use Illuminate\Http\JsonResponse;

class GenreController extends Controller
{
  protected $genreService;

  public function __construct(GenreService $genreService)
  {
    $this->genreService = $genreService;
  }

  public function index(): JsonResponse
  {
    return $this->genreService->getAllGenres();
  }

  public function show($id): JsonResponse
  {
    $page = request()->query('page', 1);

    return $this->genreService->getGenreWithMovies($id, $page);
  }

  public function store(StoreGenreRequest $request): JsonResponse
  {
    $validated = $request->validated();
    return $this->genreService->createGenre($validated);
  }

  public function update(UpdateGenreRequest $request, int $id): JsonResponse
  {
    $validated = $request->validated();
    return $this->genreService->updateGenre($id, $validated);
  }

  public function destroy(int $id): JsonResponse
  {
    return $this->genreService->deleteGenre($id);
  }
}
