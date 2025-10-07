<?php

namespace Database\Seeders;

use App\Enums\PermissionLevelEnum;
use App\Models\ProfilePermission;
use Illuminate\Database\Seeder;
use App\Models\Resource;
use App\Models\Profile;
use App\Models\Company;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
  public function run(): void
  {
    $this->call(ResourceSeeder::class);
    $obCompanyMecanica = $this->makeCompanyMecanica();

    $obAdminProfile = $this->makeProfileAdmin();
    $obHighLevelProfile = $this->makeHighLevelProfile();

    $this->makeUserAdmin($obAdminProfile);
    $this->makeUserMecanicaGestor($obHighLevelProfile, $obCompanyMecanica);
  }

  private function makeProfileAdmin(): Profile
  {
    $obAdminProfile = Profile::create([
      'name' => 'Administrador',
      'ds_description' => 'Acesso a todas as permissões',
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

  private function makeHighLevelProfile(): Profile
  {
    $obHighLevelProfile = Profile::create([
      'name' => 'Alto Nível (gestão)',
      'ds_description' => 'Acesso ao nível gestão',
    ]);

    foreach (Resource::all() as $sResource) {
      ProfilePermission::create([
        'profile_id' => $obHighLevelProfile->id,
        'resource_id' => $sResource->id,
        'permission_level' => PermissionLevelEnum::DELETE->level(),
      ]);
    }

    return $obHighLevelProfile;
  }

  private function makeCompanyMecanica(): Company
  {
    $obCompanyMecanica = Company::create([
      'name' => 'Mecânica Teste',
      'tp_company' => 'Mecânica',
      'ds_email' => 'mecanica@teste.com',
      'ds_phone' => '99999999999',
      'ds_address' => 'RS - Tapejara - Centro',
    ]);

    return $obCompanyMecanica;
  }

  private function makeUserAdmin($obAdminProfile)
  {
    User::create([
      'name' => 'admin',
      'email' => 'admin@admin.com',
      'password' => bcrypt('123456'),
      'profile_id' => $obAdminProfile->id,
      'company_id' => null,
    ]);
  }

  private function makeUserMecanicaGestor($obHighLevelProfile, $obCompanyMecanica)
  {
    User::create([
      'name' => 'Usuário Mecânica Teste',
      'email' => 'mecanica@admin.com',
      'password' => bcrypt('123456'),
      'profile_id' => $obHighLevelProfile->id,
      'company_id' => $obCompanyMecanica->id,
    ]);
  }
}
