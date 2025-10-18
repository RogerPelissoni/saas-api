<?php

namespace Core\Controllers;

use Core\Requests\CompanyRequest;
use Illuminate\Http\JsonResponse;
use Core\Services\CompanyService;
use Core\Controller;

class CompanyController extends Controller
{
  public function __construct(CompanyService $service)
  {
    $this->service = $service;
  }

  public function store(CompanyRequest $request): JsonResponse
  {
    return $this->service->store($request);
  }

  public function update(CompanyRequest $request, $id): JsonResponse
  {
    return $this->service->update($request, $id);
  }
}
