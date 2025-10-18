<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Core\Support\MigrationAuditables;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('profile_permission', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('profile_id');
      $table->unsignedBigInteger('resource_id');
      $table->integer('permission_level')->default(0);

      $table->foreign('profile_id')->references('id')->on('profile')->onDelete('cascade');
      $table->foreign('resource_id')->references('id')->on('resource')->onDelete('cascade');

      MigrationAuditables::init($table)->inject();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('profile_permission');
  }
};
