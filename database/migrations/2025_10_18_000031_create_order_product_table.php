<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Core\Support\MigrationAuditables;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('order_product', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('order_id');
      $table->unsignedBigInteger('product_id');
      $table->integer('nr_quantity');
      $table->decimal('vl_price_unit', 15, 2);

      $table->foreign('order_id')->references('id')->on('order')->onUpdate('cascade')->onDelete('cascade');
      $table->foreign('product_id')->references('id')->on('product')->onUpdate('cascade')->onDelete('restrict');
      MigrationAuditables::init($table)->inject();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('order_product');
  }
};

