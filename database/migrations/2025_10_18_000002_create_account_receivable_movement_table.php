<?php

use Illuminate\Database\Migrations\Migration;
use Core\Enums\AccountGeneralMovementEnum;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Core\Support\MigrationAuditables;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('account_receivable_movement', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('account_receivable_id');
      $table->decimal('vl_movement', 15, 2);
      $table->decimal('vl_discount', 15, 2);
      $table->date('da_movement');
      $table->enum('tp_movement', AccountGeneralMovementEnum::getValues());
      $table->enum('tp_payment', ['money', 'pix']);
      $table->text('ds_observations')->nullable();

      $table->foreign('account_receivable_id')->references('id')->on('account_receivable')->onUpdate('cascade')->onDelete('restrict');

      MigrationAuditables::init($table)->inject();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('account_receivable_movement');
  }
};

