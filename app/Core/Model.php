<?php

namespace App\Core;

use App\Models\User;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
  public static string $kvKey = 'id';
  public static array $kvValues = ['name'];

  protected array $autoFillables = [
    'company_id',
    'created_by',
    'updated_by',
  ];

  protected static function booted(): void
  {
    static::creating(function ($model) {
      self::injectAuditables($model, 'create');
    });

    static::updating(function ($model) {
      self::injectAuditables($model, 'update');
    });

    // static::deleting(function ($model) {
    //   // Código executado ANTES de deletar
    // });
  }

  private static function injectAuditables($model, $eventType): void
  {
    $obCurrentUser = User::current();

    if ($eventType === 'create') {
      if (!$obCurrentUser->company_id && !$model->company_id) {
        throw new \Exception("Usuário não possui Empresa vinculada, impossibilitando a criação de registros 'avulsos'");
      }

      $model->company_id = $obCurrentUser->company_id;
      $model->created_by = $obCurrentUser->id;
      $model->updated_by = $obCurrentUser->id;
    } else if ($eventType === 'update') {
      $model->updated_by = $obCurrentUser->id;
    }
  }
}
