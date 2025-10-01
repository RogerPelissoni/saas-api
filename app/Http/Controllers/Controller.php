<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class Controller
{
  protected string $model;

  public function index(): JsonResponse
  {
    return response()->json([
      'data' => $this->model::all(),
    ]);
  }

  public function show(string $id): JsonResponse
  {
    return response()->json([
      'data' => $this->model::find($id)
    ]);
  }

  public function store(Request $request): JsonResponse
  {
    $modelClass = $this->model;
    $fillableFields = (new $modelClass())->getFillable();

    $obModel = $modelClass::create($request->only($fillableFields));

    return response()->json([
      'message' => 'Operação efetuada com sucesso',
      'data' => $obModel,
    ]);
  }

  public function update(Request $request, $id): JsonResponse
  {
    $modelClass = $this->model;

    $obModel = $modelClass::findOrFail($id);
    $obModel->update($request->only($obModel->getFillable()));

    return response()->json([
      'message' => 'Operação efetuada com sucesso',
      'data' => $obModel,
    ]);
  }

  public function destroy(string $id): JsonResponse
  {
    $this->model::find($id)->delete();

    return response()->json([
      'message' => 'Operação efetuada com sucesso'
    ]);
  }
}
