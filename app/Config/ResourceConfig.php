<?php
namespace App\Config;

use App\Models\Resource;

class ResourceConfig
{
  public static function get(): array
  {
    return [
      ['name' => 'Clientes', 'signature' => 'client'],
      ['name' => 'Empresas', 'signature' => 'company'],
      ['name' => 'Perfil', 'signature' => 'profile'],
      ['name' => 'Usuário', 'signature' => 'user'],
    ];
  }

  public static function sync()
  {
    $arrResources = self::get();

    foreach ($arrResources as $sResource) {
      Resource::updateOrCreate([
        'signature' => $sResource['signature']
      ], [
        'name' => $sResource['name']
      ]);
    }

    $arrResources = array_column($arrResources, 'signature');
    Resource::whereNotIn('signature', $arrResources)->delete();
  }
}