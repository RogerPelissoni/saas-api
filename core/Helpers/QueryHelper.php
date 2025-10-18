<?php
namespace Core\Helpers;

use Core\Helpers\ResponseHelper;

class QueryHelper
{
  public static function resolve($obModel, $request)
  {
    QueryHelper::injectFilters($obModel, $request->filters);
    QueryHelper::injectSort($obModel, $request->sort);

    $data = empty($request->perPage)
      ? $obModel->get()
      : $obModel->paginate($request->perPage);

    return ResponseHelper::success(data: $data);
  }

  public static function injectFilters(&$obModel, $requestFilters): void
  {
    $arrFilters = json_decode($requestFilters, true);

    foreach ($arrFilters ?? [] as $paramsFilter) {
      $matchMode = $paramsFilter['matchMode'];
      $vlFilter = $paramsFilter['value'];

      if ($matchMode === 'like') {
        $vlFilter = "%$vlFilter%";
      }

      $obModel->where($paramsFilter['field'], $matchMode, $vlFilter);
    }
  }

  public static function injectSort(&$obModel, $requestSort): void
  {
    $paramsSort = json_decode($requestSort, true);

    if (!isset($paramsSort['direction'])) {
      return;
    }

    $orderColumn = $paramsSort['columnFilter'] ?? $paramsSort['columnBase'];
    $obModel->orderBy($orderColumn, $paramsSort['direction']);
  }
}
