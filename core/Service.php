<?php

namespace Core;

use Illuminate\Http\JsonResponse;
use Core\Helpers\ResponseHelper;
use Core\Helpers\QueryHelper;
use Illuminate\Http\Request;

abstract class Service
{
  protected string $model;

  public function index(Request $request): JsonResponse
  {
    $obModel = $this->model::query();
    return QueryHelper::resolve($this->model, $obModel, $request);
  }

  public function show(string $id): JsonResponse
  {
    return ResponseHelper::success(data: $this->model::findOrFail($id));
  }

  public function keyValue(Request $request)
  {
    $obModel = new $this->model;
    $mainTable = $obModel->getTable();

    $kvKey = $this->model::$kvKey ?? 'id';
    $kvValues = $this->model::$kvValues ?? ['name'];

    $queryModelBase = $this->model::query();

    $arrJoins = [];
    $arrSelects = ["{$mainTable}.{$kvKey}"];
    $relationsToLoad = [];
    $useWith = false;

    foreach ($kvValues as $nmValueField) {
      if (str_contains($nmValueField, '.')) {
        [$nmRelation, $nmRelationColumn] = explode('.', $nmValueField, 2);

        $obRelation = $obModel->{$nmRelation}();

        if ($obRelation instanceof \Illuminate\Database\Eloquent\Relations\BelongsTo) {
          $obRelated = $obRelation->getRelated();
          $relatedTable = $obRelated->getTable();
          $foreignKey = $obRelation->getQualifiedForeignKeyName(); // ex: client.person_id
          $ownerKey = $obRelation->getQualifiedOwnerKeyName(); // ex: person.id

          if (!in_array($relatedTable, $arrJoins)) {
            $queryModelBase->leftJoin($relatedTable, $foreignKey, '=', $ownerKey);
            $arrJoins[] = $relatedTable;
          }

          $arrSelects[] = "$relatedTable.$nmRelationColumn";
        } else {
          $useWith = true;
          $relationsToLoad[] = $nmRelation;
        }
      } else {
        $arrSelects[] = "{$mainTable}.{$nmValueField}";
      }
    }

    if (!$useWith) {
      $kvSeparator = ' - ';
      $concatColumns = collect($arrSelects)
        ->reject(fn($s) => $s === "{$mainTable}.{$kvKey}")
        ->map(fn($s) => str_contains($s, ' as ') ? explode(' as ', $s)[0] : $s)
        ->implode(", '{$kvSeparator}', ");

      $kvData = $queryModelBase
        ->selectRaw("{$mainTable}.{$kvKey}, CONCAT($concatColumns) as value")
        ->pluck('value', "{$mainTable}.{$kvKey}")
        ->toArray();
    } else {
      $data = $this->model::with(array_unique($relationsToLoad))->get();

      $kvData = $data->mapWithKeys(function ($item) use ($kvValues, $kvKey) {
        $values = collect($kvValues)->map(fn($f) => data_get($item, $f))->filter()->join(' - ');
        return [$item->{$kvKey} => $values];
      })->toArray();
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
