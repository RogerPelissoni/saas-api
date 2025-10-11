<?php
namespace App\Core;

class QueryHelper
{
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
}
