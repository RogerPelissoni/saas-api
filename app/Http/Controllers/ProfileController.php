<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Http\JsonResponse;
use App\Services\ProfileService;
use Illuminate\Http\Request;
use App\Core\Controller;

class ProfileController extends Controller
{
  public function __construct(ProfileService $service)
  {
    $this->service = $service;
  }

  public function store(ProfileRequest $request): JsonResponse
  {
    return $this->service->store($request);
  }

  public function update(ProfileRequest $request, $id): JsonResponse
  {
    return $this->service->update($request, $id);
  }

  public function getPermissionsByProfile(Request $request)
  {
    return $this->service->getPermissionsByProfile($request);
  }
}
