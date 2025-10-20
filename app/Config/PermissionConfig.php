<?php
namespace App\Config;

use Core\Config\PermissionConfigCore;
use Core\Enums\PermissionLevelEnum;

class PermissionConfig extends PermissionConfigCore
{
  protected static function default(): array
  {
    // $permissionLevelRead = PermissionLevelEnum::READ->value;

    return [
      // 'event' => ['permission_level' => $permissionLevelRead]
    ];
  }
}