<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use Illuminate\Http\JsonResponse;
use App\Services\StockService;
use Core\Controller;

class StockController extends Controller
{
  public function __construct(StockService $service)
  {
    $this->service = $service;
  }

  public function store(StockRequest $request): JsonResponse
  {
    return $this->service->store($request);
  }

  public function update(StockRequest $request, $id): JsonResponse
  {
    return $this->service->update($request, $id);
  }
}
