<?php
namespace App\Config;

class MultipleRoutesConfig
{
  public static function getAllowedMethods(): array
  {
    return [
      'client' => [\App\Http\Controllers\ClientController::class, 'index'],
      'event' => [\App\Http\Controllers\EventController::class, 'index'],
    ];
  }
}