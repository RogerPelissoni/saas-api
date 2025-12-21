<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\JsonResponse;
use App\Services\ProductService;
use Core\Controller;

class ProductController extends Controller
{
  public function __construct(ProductService $service)
  {
    $this->service = $service;
  }

  public function store(ProductRequest $request): JsonResponse
  {
    return $this->service->store($request);
  }

  public function update(ProductRequest $request, $id): JsonResponse
  {
    return $this->service->update($request, $id);
  }
}
