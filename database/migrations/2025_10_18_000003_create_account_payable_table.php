<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Core\Enums\AccountGeneralStatusEnum;
use Illuminate\Support\Facades\Schema;
use Core\Support\MigrationAuditables;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('account_payable', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('person_id');

      $table->string('ds_title');
      $table->integer('nr_installment');

      $table->decimal('vl_total', 15, 2);
      $table->decimal('vl_balance', 15, 2);

      $table->date('da_due');
      $table->date('da_received')->nullable();

      $table->enum('tp_status', AccountGeneralStatusEnum::getValues());
      $table->text('ds_observations')->nullable();

      $table->foreign('person_id')->references('id')->on('person')->onUpdate('cascade')->onDelete('restrict');
      $table->unique(['ds_title', 'nr_installment']);

      MigrationAuditables::init($table)->inject();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('account_payable');
  }
};

