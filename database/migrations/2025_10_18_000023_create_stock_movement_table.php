<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Core\Support\MigrationAuditables;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('stock_movement', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('product_id');
      $table->integer('nr_quantity');
      $table->enum('tp_action', ['input', 'output']);

      $table->foreign('product_id')->references('id')->on('product')->onUpdate('cascade')->onDelete('restrict');
      MigrationAuditables::init($table)->inject();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('stock_movement');
  }
};

