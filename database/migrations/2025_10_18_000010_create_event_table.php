<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Core\Support\MigrationAuditables;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('event', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('client_id');
      $table->unsignedBigInteger('professional_id');
      $table->unsignedBigInteger('account_receivable_id')->nullable();

      $table->string('ds_title');
      $table->text('ds_description')->nullable();
      $table->decimal('vl_price', 15, 2);
      $table->datetime('dt_start');
      $table->datetime('dt_end');
      $table->enum('tp_status', ['scheduled', 'done', 'canceled'])->default('scheduled');

      $table->foreign('client_id')->references('id')->on('client')->onUpdate('cascade')->onDelete('restrict');
      $table->foreign('professional_id')->references('id')->on('professional')->onUpdate('cascade')->onDelete('restrict');
      $table->foreign('account_receivable_id')->references('id')->on('account_receivable')->onUpdate('cascade')->onDelete('restrict');
      MigrationAuditables::init($table)->inject();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('event');
  }
};

