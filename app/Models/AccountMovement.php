<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Core\Helpers\QueryHelper;
use Core\Model;

class AccountMovement extends Model
{
  protected $table = null;
  public static bool $withoutTableOrderBy = true;

  public static function allAccounts($request)
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
      DB::raw("'receivable' as tp_movement"),
      DB::raw("EXISTS (
        SELECT 1
        FROM account_receivable_movement arm
        WHERE arm.account_receivable_id = account_receivable.id
      ) AS fl_exists_movement"),
    ])
      ->leftJoin('person', 'person.id', '=', 'account_receivable.person_id');

    $obAccountPayable = AccountPayable::select([
      ...collect($arrCommonFields)->map(fn($field) => "account_payable.$field as $field"),
      ...$arrPersonFields,
      DB::raw("'payable' as tp_movement"),
      DB::raw("EXISTS (
        SELECT 1
        FROM account_payable_movement apm
        WHERE apm.account_payable_id = account_payable.id
      ) AS fl_exists_movement"),
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

  public static function getMovementsByAccount($request)
  {
    $idAccount = $request->id_account;
    $tpAccount = $request->tp_account;

    if ($tpAccount === 'receivable') {
      return AccountReceivableMovement::where('account_receivable_id', $idAccount)->get();
    } else if ($tpAccount === 'payable') {
      return AccountPayableMovement::where('account_receivable_id', $idAccount)->get();
    }
  }
}
