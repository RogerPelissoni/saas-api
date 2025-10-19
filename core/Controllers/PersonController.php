<?php

namespace Core\Controllers;

use Illuminate\Http\JsonResponse;
use Core\Requests\PersonRequest;
use Core\Services\PersonService;
use Core\Controller;

class PersonController extends Controller
{
  public function __construct(PersonService $service)
  {
    $this->service = $service;
  }

  public function store(PersonRequest $request): JsonResponse
  {
    return $this->service->store($request);
  }

  public function update(PersonRequest $request, $id): JsonResponse
  {
    return $this->service->update($request, $id);
  }
}
