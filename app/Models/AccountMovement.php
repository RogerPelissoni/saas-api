<?php

namespace App\Models;

use Core\Helpers\QueryHelper;
use Core\Model;

class AccountMovement extends Model
{
  protected $table = null;
  public static bool $withoutTableOrderBy = true;

  public static function allMovements($request)
  {
    $arrCommonFields = [
      'id',
      'person_id',
      'ds_title',
      'nr_installment',
      'vl_total',
      'vl_balance',
      'da_due',
      'da_settlement',
      'tp_status',
      'ds_observations',
    ];

    $arrPersonFields = [
      'person.name as ds_person',
      'person.ds_document AS ds_document',
    ];

    $obAccountReceivable = AccountReceivable::select([
      ...collect($arrCommonFields)->map(fn($field) => "account_receivable.$field as $field"),
      ...$arrPersonFields,
    ])
      ->leftJoin('person', 'person.id', '=', 'account_receivable.person_id');

    $obAccountPayable = AccountPayable::select([
      ...collect($arrCommonFields)->map(fn($field) => "account_payable.$field as $field"),
      ...$arrPersonFields,
    ])
      ->leftJoin('person', 'person.id', '=', 'account_payable.person_id');

    QueryHelper::injectFilters(AccountReceivable::class, $obAccountReceivable, $request->filters);
    QueryHelper::injectFilters(AccountPayable::class, $obAccountPayable, $request->filters);

    $obAccountReceivable->unionAll($obAccountPayable);

    QueryHelper::injectSort(self::class, $obAccountReceivable, $request->sort);

    return empty($request->perPage)
      ? $obAccountReceivable->get()
      : $obAccountReceivable->paginate($request->perPage);
  }
}
