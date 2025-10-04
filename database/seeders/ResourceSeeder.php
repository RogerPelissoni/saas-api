<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resource;

class ResourceSeeder extends Seeder
{
  public function run(): void
  {
    $this->seedResources();
  }

  private function seedResources(): void
  {
    $resources = [
      ['name' => 'Perfil', 'resource' => 'profile'],
      ['name' => 'Usuário', 'resource' => 'user'],
    ];

    foreach ($resources as $res) {
      Resource::updateOrCreate(
        ['resource' => $res['resource']],
        $res
      );
    }
  }
}
