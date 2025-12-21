<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', \Core\Middleware\RouteAccessMiddleware::class])->group(function () {
  // Get
  Route::get('accountmovement', [\App\Http\Controllers\AccountMovementController::class, 'index']);
  Route::get('accountmovement/movementsByAccount', [\App\Http\Controllers\AccountMovementController::class, 'indexMovementsByAccount']);
  // Post
  Route::post('accountmovement', [\App\Http\Controllers\AccountMovementController::class, 'store']);
  Route::post('accountmovement/paymenyReversal', [\App\Http\Controllers\AccountMovementController::class, 'storePaymentReversal']);
  // Resources
  Route::apiResource('accountpayable', \App\Http\Controllers\AccountPayableController::class);
  Route::apiResource('accountreceivable', \App\Http\Controllers\AccountReceivableController::class);
  Route::apiResource('client', \App\Http\Controllers\ClientController::class);
  Route::apiResource('event', \App\Http\Controllers\EventController::class);
  Route::apiResource('product', \App\Http\Controllers\ProductController::class);
  Route::apiResource('productcategory', \App\Http\Controllers\ProductCategoryController::class);
  Route::apiResource('professional', \App\Http\Controllers\ProfessionalController::class);
});
