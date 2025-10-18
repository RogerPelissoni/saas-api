<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Core\Support\MigrationAuditables;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('event_message', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('event_id');
      $table->string('ds_message');

      $table->foreign('event_id')->references('id')->on('event')->onUpdate('cascade')->onDelete('cascade');
      MigrationAuditables::init($table)->inject();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('event_message');
  }
};

