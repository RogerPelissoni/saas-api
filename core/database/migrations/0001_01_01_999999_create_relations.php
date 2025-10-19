<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::table('profile', function (Blueprint $table) {
      $table->unsignedBigInteger('created_by')->references('id')->on('users');
      $table->unsignedBigInteger('updated_by')->references('id')->on('users');

      $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
      $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
    });

    Schema::table('person', function (Blueprint $table) {
      $table->unsignedBigInteger('created_by')->references('id')->on('users');
      $table->unsignedBigInteger('updated_by')->references('id')->on('users');

      $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
      $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
    });
  }

  public function down(): void
  {
  }
};
