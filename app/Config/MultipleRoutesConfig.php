<?php
namespace App\Config;

use Core\Config\MultipleRoutesCoreConfig;

class MultipleRoutesConfig extends MultipleRoutesCoreConfig
{
  protected static function getAllowedMethods(): array
  {
    return [
      'client' => [\App\Http\Controllers\ClientController::class, 'index'],
      'event' => [\App\Http\Controllers\EventController::class, 'index'],
      'product' => [\App\Http\Controllers\ProductController::class, 'index'],
      'productcategory' => [\App\Http\Controllers\ProductCategoryController::class, 'index'],
      'professional' => [\App\Http\Controllers\ProfessionalController::class, 'index'],
    ];
  }
}