<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfessionalRequest;
use Illuminate\Http\JsonResponse;
use App\Services\ProfessionalService;
use Core\Controller;

class ProfessionalController extends Controller
{
  public function __construct(ProfessionalService $service)
  {
    $this->service = $service;
  }

  public function store(ProfessionalRequest $request): JsonResponse
  {
    return $this->service->store($request);
  }

  public function update(ProfessionalRequest $request, $id): JsonResponse
  {
    return $this->service->update($request, $id);
  }
}
