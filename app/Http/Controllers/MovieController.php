<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Services\MovieService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MovieController extends Controller
{
  protected $movieService;

  public function __construct(MovieService $movieService)
  {
    $this->movieService = $movieService;
  }

  public function index(Request $request): JsonResponse
  {
    $page = $request->query('page', 1);

    return $this->movieService->getAllMovies($page);
  }

  public function show(int $id): JsonResponse
  {
    return $this->movieService->getMovieById($id);
  }

  public function store(StoreMovieRequest $request): JsonResponse
  {
    $validated = $request->validated();
    return $this->movieService->createMovie($validated);
  }

  public function update(UpdateMovieRequest $request, int $id): JsonResponse
  {
    $validated = $request->validated();
    return $this->movieService->updateMovie($id, $validated);
  }

  public function destroy(int $id): JsonResponse
  {
    return $this->movieService->deleteMovie($id);
  }

  public function publish(int $id): JsonResponse
  {
    return $this->movieService->publishMovie($id);
  }
}
