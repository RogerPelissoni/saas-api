<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use Illuminate\Http\JsonResponse;
use App\Services\CompanyService;
use App\Core\Controller;

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
