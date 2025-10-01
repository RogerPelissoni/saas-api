<?php

use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
  Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
  Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

  Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [\App\Http\Controllers\Api\AuthController::class, 'me']);
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
  });
});

Route::middleware('auth:sanctum')->group(function () {
  Route::apiResource('client', \App\Http\Controllers\Api\ClientController::class);
  Route::apiResource('profile', \App\Http\Controllers\Api\ProfileController::class);
  Route::apiResource('user', \App\Http\Controllers\Api\UserController::class);
});
