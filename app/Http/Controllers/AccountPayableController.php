<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountPayableRequest;
use App\Services\AccountPayableService;
use Illuminate\Http\JsonResponse;
use Core\Controller;

class AccountPayableController extends Controller
{
  public function __construct(AccountPayableService $service)
  {
    $this->service = $service;
  }

  public function store(AccountPayableRequest $request): JsonResponse
  {
    return $this->service->store($request);
  }

  public function update(AccountPayableRequest $request, $id): JsonResponse
  {
    return $this->service->update($request, $id);
  }
}
