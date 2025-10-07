<?php

namespace Database\Seeders;

use App\Enums\PermissionLevelEnum;
use App\Models\ProfilePermission;
use Illuminate\Database\Seeder;
use App\Models\Resource;
use App\Models\Profile;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
  public function run(): void
  {
    $this->call(ResourceSeeder::class);
    $obAdminProfile = $this->makeProfileAdmin();

    User::create([
      'name' => 'admin',
      'email' => 'admin@admin.com',
      'password' => bcrypt('123456'),
      'profile_id' => $obAdminProfile->id,
    ]);
  }

  private function makeProfileAdmin(): Profile
  {
    $obAdminProfile = Profile::create([
      'name' => 'Administrador',
      'description' => 'Acesso a todas as permissões',
    ]);

    foreach (Resource::all() as $sResource) {
      ProfilePermission::create([
        'profile_id' => $obAdminProfile->id,
        'resource_id' => $sResource->id,
        'permission_level' => PermissionLevelEnum::ADMIN->level(),
      ]);
    }

    return $obAdminProfile;
  }
}
