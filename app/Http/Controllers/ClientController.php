<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use Illuminate\Http\JsonResponse;
use App\Services\ClientService;
use Core\Controller;

class ClientController extends Controller
{
  public function __construct(ClientService $service)
  {
    $this->service = $service;
  }

  public function store(ClientRequest $request): JsonResponse
  {
    return $this->service->store($request);
  }

  public function update(ClientRequest $request, $id): JsonResponse
  {
    return $this->service->update($request, $id);
  }
}
