<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Core\Support\MigrationAuditables;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('client', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('ds_mail')->nullable();
      $table->string('ds_phone')->nullable();
      $table->string('ds_address')->nullable();
      $table->date('da_birth')->nullable();
      // $table->json('meta')->nullable(); // campos extras por tipo de empresa

      MigrationAuditables::init($table)->inject();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('client');
  }
};

