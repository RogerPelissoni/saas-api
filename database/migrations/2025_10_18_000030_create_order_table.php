<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Core\Support\MigrationAuditables;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('order', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('client_id');
      $table->unsignedBigInteger('account_receivable_id');
      $table->datetime('dt_order');
      $table->datetime('dt_delivery');
      $table->enum('tp_status', ['preparation', 'delivered']);
      $table->text('ds_observations');

      $table->foreign('client_id')->references('id')->on('client')->onUpdate('cascade')->onDelete('restrict');
      $table->foreign('account_receivable_id')->references('id')->on('account_receivable')->onUpdate('cascade')->onDelete('restrict');
      MigrationAuditables::init($table)->inject();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('order');
  }
};

