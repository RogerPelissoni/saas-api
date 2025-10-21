<?php

namespace Core;

use Illuminate\Support\Facades\Schema;
use Core\Scopes\CompanyScope;
use App\Models\User;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
  public static string $kvKey = 'id';
  public static array $kvValues = ['name'];

  protected static array $tableCache = [];
  protected array $autoFillables = [
    'company_id',
    'created_by',
    'updated_by',
  ];

  protected static function booted(): void
  {
    static::addGlobalScope(new CompanyScope);

    static::creating(fn($model) => self::injectAuditables($model, 'create'));
    static::updating(fn($model) => self::injectAuditables($model, 'update'));
  }

  private static function injectAuditables($model, $eventType): void
  {
    if (app()->runningInConsole() && !app()->runningUnitTests()) {
      return;
    }

    $obCurrentUser = User::current();

    if ($eventType === 'create') {
      if (Schema::hasColumn($model->getTable(), 'company_id')) {
        if (!$obCurrentUser->company_id && !$model->company_id) {
          throw new \Exception("Usuário não possui Empresa vinculada, impossibilitando a criação de registros 'avulsos'");
        }

        $model->company_id = $obCurrentUser->company_id;
      }

      if (Schema::hasColumn($model->getTable(), 'created_by')) {
        $model->created_by = $obCurrentUser->id;
      }

      if (Schema::hasColumn($model->getTable(), 'updated_by')) {
        $model->updated_by = $obCurrentUser->id;
      }
    } else if ($eventType === 'update') {
      if (Schema::hasColumn($model->getTable(), 'updated_by')) {
        $model->updated_by = $obCurrentUser->id;
      }
    }
  }

  protected static function hasColumnCached(string $column): bool
  {
    $table = (new static)->getTable();

    if (!isset(self::$tableCache[$table])) {
      self::$tableCache[$table] = \Illuminate\Support\Facades\Schema::getColumnListing($table);
    }

    return in_array($column, self::$tableCache[$table], true);
  }

  public static function getBindFilters(): array
  {
    return [];
  }
}
