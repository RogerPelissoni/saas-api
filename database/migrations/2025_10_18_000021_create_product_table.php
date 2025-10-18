<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Core\Support\MigrationAuditables;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('product', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('product_category_id');

      $table->string('name');
      $table->text('ds_description')->nullable();
      $table->decimal('vl_price', 15, 2);
      $table->string('ds_code')->nullable();
      $table->boolean('fl_active');

      $table->foreign('product_category_id')->references('id')->on('product_category')->onUpdate('cascade')->onDelete('restrict');
      MigrationAuditables::init($table)->inject();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('product');
  }
};

