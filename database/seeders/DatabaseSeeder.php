<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
  public function run(): void
  {
    $this->call(ResourceSeeder::class);

    $obAdminProfile = Profile::create([
      'name' => 'Administrador',
    ]);

    User::create([
      'name' => 'admin',
      'email' => 'admin@admin.com',
      'password' => bcrypt('123456'),
      'profile_id' => $obAdminProfile->id,
    ]);
  }
}
