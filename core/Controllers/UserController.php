<?php

namespace Core\Controllers;

use Core\Requests\UserRequest;
use Illuminate\Http\JsonResponse;
use Core\Services\UserService;
use Core\Controller;

class UserController extends Controller
{
  public function __construct(UserService $service)
  {
    $this->service = $service;
  }

  public function store(UserRequest $request): JsonResponse
  {
    return $this->service->store($request);
  }

  public function update(UserRequest $request, $id): JsonResponse
  {
    return $this->service->update($request, $id);
  }
}
