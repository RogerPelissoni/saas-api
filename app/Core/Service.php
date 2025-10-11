<?php

namespace App\Core;

use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseHelper;
use Illuminate\Http\Request;

abstract class Service
{
  protected string $model;

  public function index(Request $request): JsonResponse
  {
    $obModel = $this->model::query();
    QueryHelper::injectFilters($obModel, $request->filters);

    return ResponseHelper::success(data: $obModel->get());
  }

  public function show(string $id): JsonResponse
  {
    return ResponseHelper::success(data: $this->model::findOrFail($id));
  }
  public function keyValue(Request $request)
  {
    $kvKey = $this->model::$kvKey ?? 'id';
    $kvValues = $this->model::$kvValues ?? ['name'];

    if (count($kvValues) > 1) {
      $kvSeparator = ' - ';
      $concatColumns = implode(", '{$kvSeparator}', ", $kvValues);

      $kvData = $this->model::selectRaw("{$kvKey}, CONCAT($concatColumns) as value")
        ->pluck('value', $kvKey)
        ->toArray();
    } else {
      $kvData = $this->model::pluck($kvValues[0], $kvKey)->toArray();
    }

    return ResponseHelper::success(data: $kvData);
  }

  public function store(Request $request): JsonResponse
  {
    $modelClass = $this->model;
    $fillableFields = (new $modelClass())->getFillable();

    $obModel = $modelClass::create($request->only($fillableFields));

    return ResponseHelper::success(data: $obModel);
  }

  public function update(Request $request, $id): JsonResponse
  {
    $modelClass = $this->model;

    $obModel = $modelClass::findOrFail($id);
    $obModel->update($request->only($obModel->getFillable()));

    return ResponseHelper::success(data: $obModel);
  }

  public function destroy(string $id): JsonResponse
  {
    $this->model::findOrFail($id)->delete();
    return ResponseHelper::success();
  }
}
