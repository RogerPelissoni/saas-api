<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
use Illuminate\Http\JsonResponse;
use App\Services\ProductCategoryService;
use Core\Controller;

class ProductCategoryController extends Controller
{
  public function __construct(ProductCategoryService $service)
  {
    $this->service = $service;
  }

  public function store(ProductCategoryRequest $request): JsonResponse
  {
    return $this->service->store($request);
  }

  public function update(ProductCategoryRequest $request, $id): JsonResponse
  {
    return $this->service->update($request, $id);
  }
}
