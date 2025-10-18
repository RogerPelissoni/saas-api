<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', \Core\Middleware\RouteAccessMiddleware::class])->group(function () {
  // Get
  // Post
  // Resources
  Route::apiResource('client', \App\Http\Controllers\ClientController::class);
});
