<?php

use App\Http\Middleware\RouteAccessMiddleware;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
  Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
  Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');

  Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [\App\Http\Controllers\AuthController::class, 'me']);
    Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout']);
  });
});

Route::middleware(['auth:sanctum', RouteAccessMiddleware::class])->group(function () {
  // Get
  // Post
  Route::post('multiple', [\App\Http\Controllers\MultipleController::class, 'index']);
  Route::post('profile/permissions', [\App\Http\Controllers\ProfileController::class, 'getPermissionsByProfile']);
  // Resources
  Route::apiResource('client', \App\Http\Controllers\ClientController::class);
  Route::apiResource('profile', \App\Http\Controllers\ProfileController::class);
  Route::apiResource('user', \App\Http\Controllers\UserController::class);
});
