<?php

use Core\Enums\EventStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Core\Support\MigrationAuditables;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('event', function (Blueprint $table) {
      $table->id();
      $table->string('ds_title');
      $table->text('ds_description')->nullable();
      $table->datetime('dt_start');
      $table->datetime('dt_end');
      $table->enum('tp_status', EventStatusEnum::getValues())->default('scheduled');

      MigrationAuditables::init($table)->inject();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('event');
  }
};

