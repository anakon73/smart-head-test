<?php

use App\Http\Controllers\GenreController;
use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::prefix('genres')->group(function () {
  Route::get('/', [GenreController::class, 'index']);
  Route::get('/{id}', [GenreController::class, 'show']);
  Route::post('/', [GenreController::class, 'store']);
  Route::patch('/{id}', [GenreController::class, 'update']);
  Route::delete('/{id}', [GenreController::class, 'destroy']);
});

Route::prefix('movies')->group(function () {
  Route::get('/', [MovieController::class, 'index']);
  Route::get('/{id}', [MovieController::class, 'show']);
  Route::post('/', [MovieController::class, 'store']);
  Route::patch('/{id}', [MovieController::class, 'update']);
  Route::patch('/{id}/publish', [MovieController::class, 'publish']);
  Route::delete('/{id}', [MovieController::class, 'destroy']);
});
