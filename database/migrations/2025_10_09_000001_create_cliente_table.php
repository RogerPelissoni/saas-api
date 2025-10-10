<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Core\MigrationAuditables;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('cliente', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('ds_email')->nullable();
      $table->string('ds_telefone')->nullable();
      $table->date('da_nascimento')->nullable();
      // $table->json('meta')->nullable(); // campos extras por tipo de empresa

      MigrationAuditables::init($table)->inject();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('cliente');
  }
};

