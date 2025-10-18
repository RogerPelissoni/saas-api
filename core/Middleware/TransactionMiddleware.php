<?php

namespace Core\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionMiddleware
{
  public function handle(Request $request, Closure $next)
  {
    $mutating = in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE']);

    if (!$mutating) {
      return $next($request);
    }

    return DB::transaction(fn() => $next($request));
  }
}