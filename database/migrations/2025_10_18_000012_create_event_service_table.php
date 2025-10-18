<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Core\Support\MigrationAuditables;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('event_service', function (Blueprint $table) {
      $table->id();
      $table->string('ds_title');
      $table->text('ds_description');
      $table->decimal('vl_price', 15, 2);
      $table->boolean('fl_active');

      MigrationAuditables::init($table)->inject();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('event_service');
  }
};

