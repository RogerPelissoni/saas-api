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
      $table->unsignedBigInteger('person_id');
      $table->date('da_registration')->nullable();

      $table->foreign('person_id')->references('id')->on('person')->onUpdate('cascade')->onDelete('restrict');
      MigrationAuditables::init($table)->inject();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('client');
  }
};

