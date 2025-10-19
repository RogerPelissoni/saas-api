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
      'professional' => [\App\Http\Controllers\ProfessionalController::class, 'index'],
    ];
  }
}