<?php
namespace Core\Support;

class MigrationAuditables
{
  protected $table;
  protected $company = true;
  protected $users = true;
  protected $timestamps = true;
  protected $softDeletes = true;

  public static function init(&$table): MigrationAuditables
  {
    $instance = new self();
    $instance->table = $table;
    return $instance;
  }

  public function companie($company = true): static
  {
    $this->company = $company;
    return $this;
  }

  public function users($users = true): static
  {
    if (gettype($users) !== 'boolean' && $users !== 'nullable') {
      throw new \InvalidArgumentException('$users -> only accepts the parameters boolean or "nullable"');
    }

    $this->users = $users;
    return $this;
  }

  public function timestamps($timestamps = true): static
  {
    $this->timestamps = $timestamps;
    return $this;
  }

  public function inject(): void
  {
    $table = $this->table;

    if ($this->company) {
      $table->unsignedBigInteger('company_id');
      $table->foreign('company_id')->references('id')->on('company')->onUpdate('cascade')->onDelete('cascade');
    }

    if ($this->users) {
      $this->users === 'nullable'
        ? $table->unsignedBigInteger('created_by')->references('id')->on('users')->nullable()
        : $table->unsignedBigInteger('created_by')->references('id')->on('users');

      $table->foreign('created_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');

      $this->users === 'nullable'
        ? $table->unsignedBigInteger('updated_by')->references('id')->on('users')->nullable()
        : $table->unsignedBigInteger('updated_by')->references('id')->on('users');

      $table->foreign('updated_by')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
    }

    if ($this->timestamps) {
      $table->timestamps();
    }
  }
}
