<?php
namespace Core\Config;

abstract class MultipleRoutesCoreConfig
{
  protected static function getAllowedMethods(): array
  {
    return [];
  }

  protected static function getAllowedMethodsCore(): array
  {
    return [
      'company' => [\Core\Controllers\CompanyController::class, 'index'],
      'person' => [\Core\Controllers\PersonController::class, 'index'],
      'profile' => [\Core\Controllers\ProfileController::class, 'index'],
      'user' => [\Core\Controllers\UserController::class, 'index'],
    ];
  }

  public static function get(): array
  {
    return array_merge(static::getAllowedMethods(), static::getAllowedMethodsCore());
  }
}