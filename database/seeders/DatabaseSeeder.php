<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Schema;
use Core\Enums\PermissionLevelEnum;
use Core\Models\ProfilePermission;
use Illuminate\Database\Seeder;
use Core\Models\Resource;
use Core\Models\Profile;
use Core\Models\Company;
use App\Models\User;
use Core\Models\Person;

class DatabaseSeeder extends Seeder
{
  public function run(): void
  {
    $this->call(ResourceSeeder::class);
    $obCompanyMecanica = $this->makeCompanyMecanica();

    Schema::disableForeignKeyConstraints();
    $obAdminProfile = $this->makeProfileAdmin($obCompanyMecanica);
    $this->makeUserAdmin($obAdminProfile);
    Schema::enableForeignKeyConstraints();

    $obHighLevelProfile = $this->makeHighLevelProfile($obCompanyMecanica);
    $this->makeUserMecanicaGestor($obHighLevelProfile, $obCompanyMecanica);
  }

  private function makeProfileAdmin($obCompanyMecanica): Profile
  {
    $obAdminProfile = Profile::create([
      'name' => 'Administrador',
      'ds_description' => 'Acesso a todas as permissões',
      'company_id' => $obCompanyMecanica->id,
      ...$this->getAuditables()
    ]);

    foreach (Resource::all() as $sResource) {
      ProfilePermission::create([
        'profile_id' => $obAdminProfile->id,
        'resource_id' => $sResource->id,
        'permission_level' => PermissionLevelEnum::ADMIN->level(),
        'company_id' => $obCompanyMecanica->id,
        ...$this->getAuditables()
      ]);
    }

    return $obAdminProfile;
  }

  private function makeHighLevelProfile($obCompanyMecanica): Profile
  {
    $obHighLevelProfile = Profile::create([
      'name' => 'Alto Nível (gestão)',
      'ds_description' => 'Acesso ao nível gestão',
      'company_id' => $obCompanyMecanica->id,
      ...$this->getAuditables()
    ]);

    foreach (Resource::all() as $sResource) {
      ProfilePermission::create([
        'profile_id' => $obHighLevelProfile->id,
        'resource_id' => $sResource->id,
        'permission_level' => PermissionLevelEnum::DELETE->level(),
        'company_id' => $obCompanyMecanica->id,
        ...$this->getAuditables()
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
    $obPersonMecanica = Person::create([
      'name' => 'Pessoa Mecânica',
      'company_id' => $obCompanyMecanica->id,
      ...$this->getAuditables()
    ]);

    User::create([
      'name' => 'Usuário Mecânica Teste',
      'email' => 'mecanica@admin.com',
      'password' => bcrypt('123456'),
      'profile_id' => $obHighLevelProfile->id,
      'company_id' => $obCompanyMecanica->id,
      'person_id' => $obPersonMecanica->id,
    ]);
  }

  private function getAuditables(): array
  {
    return [
      'created_by' => 1,
      'updated_by' => 1,
    ];
  }
}
