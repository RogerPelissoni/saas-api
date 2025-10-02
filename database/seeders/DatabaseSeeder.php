<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  public function run(): void
  {
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
