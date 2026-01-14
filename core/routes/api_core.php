<?php

use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
  Route::post('/register', [\Core\Controllers\AuthController::class, 'register']);
  Route::post('/login', [\Core\Controllers\AuthController::class, 'login'])->name('login');

  Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [\Core\Controllers\AuthController::class, 'me']);
    Route::post('/logout', [\Core\Controllers\AuthController::class, 'logout']);
  });
});

Route::middleware(['auth:sanctum', \Core\Middleware\RouteAccessMiddleware::class])->group(function () {
  // Get
  // Post
  Route::post('multiple', [\Core\Controllers\MultipleController::class, 'index']);
  Route::post('profile/permissions', [\Core\Controllers\ProfileController::class, 'getPermissionsByProfile']);
  // Resources
  Route::apiResource('company', \Core\Controllers\CompanyController::class);
  Route::apiResource('person', \Core\Controllers\PersonController::class);
  Route::apiResource('profile', \Core\Controllers\ProfileController::class);
  Route::apiResource('user', \Core\Controllers\UserController::class);
});

Route::get('/health', function () {
  sleep(5);
  return "I'm ALIVE!";
});
