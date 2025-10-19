<?php

use Core\Support\MigrationAuditables;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('person', function (Blueprint $table) {
      $table->id();
      $table->string('name', 150);
      $table->string('ds_document', 20)->nullable();
      $table->string('ds_email', 120)->nullable();
      $table->string('ds_phone', 20)->nullable();
      $table->date('da_birth')->nullable();
      $table->enum('tp_gender', ['M', 'F'])->nullable();
      $table->string('ds_address_street', 120)->nullable();
      $table->string('ds_address_number', 20)->nullable();
      $table->string('ds_address_complement', 60)->nullable();
      $table->string('ds_address_district', 80)->nullable();
      $table->string('ds_address_city', 80)->nullable();
      $table->string('ds_address_state', 2)->nullable();
      $table->string('ds_address_zipcode', 10)->nullable();
      $table->boolean('fl_active')->default(true);
      
      MigrationAuditables::init($table)->users(false)->inject();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('person');
  }
};
