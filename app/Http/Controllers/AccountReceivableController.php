<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountReceivableRequest;
use App\Services\AccountReceivableService;
use Illuminate\Http\JsonResponse;
use Core\Controller;

class AccountReceivableController extends Controller
{
  public function __construct(AccountReceivableService $service)
  {
    $this->service = $service;
  }

  public function store(AccountReceivableRequest $request): JsonResponse
  {
    return $this->service->store($request);
  }

  public function update(AccountReceivableRequest $request, $id): JsonResponse
  {
    return $this->service->update($request, $id);
  }
}
