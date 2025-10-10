<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Core\MigrationAuditables;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('profile', function (Blueprint $table) {
      $table->id();
      $table->string('name', 50)->unique();
      $table->text('ds_description')->nullable();

      MigrationAuditables::init($table)->users(false)->inject();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('profile');
  }
};
