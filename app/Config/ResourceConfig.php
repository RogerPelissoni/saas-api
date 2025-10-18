<?php
namespace App\Config;

use Core\Config\ResourceConfigCore;

class ResourceConfig extends ResourceConfigCore
{
  public static function get(): array
  {
    return array_merge(parent::get(), [
      ['name' => 'Clientes', 'signature' => 'client'],
    ]);
  }
}