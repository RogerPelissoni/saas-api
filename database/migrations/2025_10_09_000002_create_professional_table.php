<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Core\Support\MigrationAuditables;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('professional', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('person_id');
      $table->unsignedBigInteger('user_id')->nullable();
      $table->decimal('pc_commission', 5, 2)->default(0);
      $table->date('da_hire')->nullable();
      $table->date('da_termination')->nullable();

      $table->foreign('person_id')->references('id')->on('person')->onUpdate('cascade')->onDelete('restrict');
      $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('restrict');
      MigrationAuditables::init($table)->inject();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('professional');
  }
};
