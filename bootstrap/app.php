<?php

use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    api: __DIR__ . '/../routes/api.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware): void {
    $middleware->api(prepend: [
      \App\Http\Middleware\TransactionMiddleware::class,
      \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions): void {
    $exceptions->render(function (AuthenticationException $e, Request $request) {
      return response()->json([
        'status' => 'error',
        'message' => 'Usuário não autenticado!',
        'data' => [
          'nextAction' => 'logout',
        ]
      ], 401);
    });

    $exceptions->render(function (\Exception $e, Request $request) {
      return response()->json([
        'status' => 'error',
        'message' => $e->getMessage(),
      ], $e->getCode() ?: 400);
    });
  })->create();
