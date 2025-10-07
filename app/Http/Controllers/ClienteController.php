<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use Illuminate\Http\JsonResponse;
use App\Services\ClienteService;
use App\Core\Controller;

class ClienteController extends Controller
{
  public function __construct(ClienteService $service)
  {
    $this->service = $service;
  }

  public function store(ClienteRequest $request): JsonResponse
  {
    return $this->service->store($request);
  }

  public function update(ClienteRequest $request, $id): JsonResponse
  {
    return $this->service->update($request, $id);
  }
}
