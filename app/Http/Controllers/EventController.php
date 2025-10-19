<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use Illuminate\Http\JsonResponse;
use App\Services\EventService;
use Core\Controller;

class EventController extends Controller
{
  public function __construct(EventService $service)
  {
    $this->service = $service;
  }

  public function store(EventRequest $request): JsonResponse
  {
    return $this->service->store($request);
  }

  public function update(EventRequest $request, $id): JsonResponse
  {
    return $this->service->update($request, $id);
  }
}
