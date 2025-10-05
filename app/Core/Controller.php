<?php

namespace App\Core;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class Controller
{
  protected $service;

  public function index(Request $request)
  {
    return $this->service->index($request);
  }

  public function show($id)
  {
    return $this->service->show($id);
  }

  public function keyValue(Request $request)
  {
    return $this->service->keyValue($request);
  }

  // abstract public function store(Request $request): JsonResponse;
  // abstract public function update(Request $request, $id): JsonResponse;

  public function destroy($id): JsonResponse
  {
    return $this->service->destroy($id);
  }
}
