<?php
namespace App\Config;

use App\Models\Resource;

class ResourceConfig
{
  public static function get(): array
  {
    return [
      ['name' => 'Perfil', 'resource' => 'profile'],
      ['name' => 'Usuário', 'resource' => 'user'],
    ];
  }

  public static function sync()
  {
    $arrResources = self::get();

    foreach ($arrResources as $sResource) {
      Resource::updateOrCreate([
        'resource' => $sResource['resource']
      ], [
        'name' => $sResource['name']
      ]);
    }

    $arrResources = array_column($arrResources, 'resource');
    Resource::whereNotIn('resource', $arrResources)->delete();
  }
}