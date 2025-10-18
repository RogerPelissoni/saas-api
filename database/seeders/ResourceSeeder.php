<?php

namespace Database\Seeders;

use App\Config\ResourceConfig;
use Illuminate\Database\Seeder;
use Core\Models\Resource;

class ResourceSeeder extends Seeder
{
  public function run(): void
  {
    $this->seedResources();
  }

  private function seedResources(): void
  {
    foreach (ResourceConfig::get() as $arrResourceParams) {
      Resource::updateOrCreate(
        [
          'signature' => $arrResourceParams['signature']
        ],
        $arrResourceParams
      );
    }
  }
}
