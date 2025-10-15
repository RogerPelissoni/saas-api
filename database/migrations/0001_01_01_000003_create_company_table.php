<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('company', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('tp_company');
      $table->string('ds_email')->nullable();
      $table->string('ds_phone')->nullable();
      $table->string('ds_address')->nullable();
      
      // $table->unsignedBigInteger('plan_id')->nullable(); // plano SaaS
      /**
       * Implementar tipo de plano futuramente
       * Plano Bronze, Prata, Ouro por exemplo
       * Cada plano terá acesso a determinados modulos (financeiro, agenda, etc)
       */

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('company');
  }
};
