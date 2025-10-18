<?php

namespace Core\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use App\Models\User;

class CompanyScope implements Scope
{
  public function apply(Builder $builder, Model $model)
  {
    if (app()->runningInConsole() && !app()->runningUnitTests()) {
      return;
    }

    $obUser = User::current();

    if (!$obUser?->company_id) {
      return;
    }

    if ($model::hasColumnCached('company_id')) {
      $builder->where($model->getTable() . '.company_id', $obUser->company_id);
    }
  }
}
