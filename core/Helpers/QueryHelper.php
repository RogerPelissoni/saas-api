<?php
namespace Core\Helpers;

use Core\Helpers\ResponseHelper;

class QueryHelper
{
  public static function resolve($modelClass, $obModel, $request)
  {
    QueryHelper::injectFilters($modelClass, $obModel, $request->filters);
    QueryHelper::injectSort($modelClass, $obModel, $request->sort);

    $data = empty($request->perPage)
      ? $obModel->get()
      : $obModel->paginate($request->perPage);

    return ResponseHelper::success(data: $data);
  }

  public static function injectFilters($modelClass, &$obModel, $requestFilters): void
  {
    $arrFilters = json_decode($requestFilters, true);
    $arrBindFilters = $modelClass::getBindFilters() ?? [];

    foreach ($arrFilters ?? [] as $paramsFilter) {
      $matchMode = $paramsFilter['matchMode'];
      $vlFilter = $paramsFilter['value'];

      if ($matchMode === 'like') {
        $vlFilter = "%$vlFilter%";
      }

      if (isset($arrBindFilters[$paramsFilter['field']])) {
        $bindParams = $arrBindFilters[$paramsFilter['field']];
        $bindRelation = $bindParams['relation'];
        $arrBindFields = is_array($bindParams['field']) ? $bindParams['field'] : [$bindParams['field']];

        $obModel->withWhereHas($bindRelation, function ($q) use ($arrBindFields, $matchMode, $vlFilter) {
          $q->where(function ($subQuery) use ($arrBindFields, $matchMode, $vlFilter) {
            foreach ($arrBindFields as $bindField) {
              $subQuery->orWhere($bindField, $matchMode, $vlFilter);
            }
          });
        });
      } else {
        $obModel->where($paramsFilter['field'], $matchMode, $vlFilter);
      }
    }
  }

  public static function injectSort($modelClass, &$obModel, $requestSort): void
  {
    $paramsSort = json_decode($requestSort, true);
    if (!isset($paramsSort['direction'])) {
      return;
    }

    $arrBindFilters = $modelClass::getBindFilters() ?? [];
    $mainTable = $obModel->getModel()->getTable();

    $orderColumn = $paramsSort['columnFilter'] ?? $paramsSort['columnBase'];
    $direction = strtolower($paramsSort['direction']) === 'desc' ? 'desc' : 'asc';

    if (isset($arrBindFilters[$orderColumn])) {
      $relation = $arrBindFilters[$orderColumn]['relation'] ?? null;
      $field = $arrBindFilters[$orderColumn]['field'] ?? $orderColumn;

      if ($relation && method_exists($obModel->getModel(), $relation)) {
        $relationModel = $obModel->getModel()->$relation()->getRelated();
        $foreignKey = $obModel->getModel()->$relation()->getQualifiedForeignKeyName();
        $ownerKey = $obModel->getModel()->$relation()->getQualifiedOwnerKeyName();

        $obModel->orderBy(
          $relationModel::select($field)->whereColumn($ownerKey, $foreignKey),
          $direction
        );

        return;
      }
    }

    $orderColumn = ($modelClass::$withoutTableOrderBy ?? false)
      ? $orderColumn
      : "$mainTable.$orderColumn";

    $obModel->orderBy($orderColumn, $direction);
  }
}
