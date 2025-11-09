<?php

namespace App\Http\Controllers;

use Core\Enums\AccountGeneralMovementEnum;
use App\Models\AccountReceivableMovement;
use Core\Enums\AccountGeneralStatusEnum;
use App\Models\AccountPayableMovement;
use App\Models\AccountReceivable;
use Core\Helpers\ResponseHelper;
use App\Models\AccountMovement;
use App\Models\AccountPayable;
use Illuminate\Http\Request;

class AccountMovementController
{
  public function index(Request $request)
  {
    return ResponseHelper::success(data: AccountMovement::allAccounts($request));
  }

  public function indexMovementsByAccount(Request $request)
  {
    return ResponseHelper::success(data: AccountMovement::getMovementsByAccount($request));
  }

  public function store(Request $request)
  {
    $arrAccountMovements = $request->accountMovements ?? [];
    $daMovement = $request->daMovement;
    $tpPayment = $request->tpPayment;

    throw_if(empty($arrAccountMovements), "Selecione ao menos um Título para prosseguir");
    throw_if(!$daMovement, "Selecione a Data de Baixa para prosseguir");
    throw_if(!$tpPayment, "Selecione a Forma de Pagamento para prosseguir");

    foreach ($arrAccountMovements as $sAccountMovement) {
      $tpMovement = $sAccountMovement['tp_movement'];
      $vlPaid = $sAccountMovement['vl_paid'] ?? null;

      throw_if(!$vlPaid, "Título Nº $sAccountMovement[ds_title] - Valor de Baixa não selecionado");

      $accountClass = $tpMovement === 'receivable' ? AccountReceivable::class : AccountPayable::class;
      $accountForeignField = $tpMovement === 'receivable' ? 'account_receivable_id' : 'account_payable_id';
      $accountMovementClass = $tpMovement === 'receivable' ? AccountReceivableMovement::class : AccountPayableMovement::class;

      $obAccount = $accountClass::findOrFail($sAccountMovement['id']);

      $accountMovementClass::create([
        $accountForeignField => $obAccount->id,
        'vl_movement' => $vlPaid,
        'vl_discount' => 0,
        'da_movement' => $daMovement,
        'tp_movement' => AccountGeneralMovementEnum::NORMAL->value,
        'tp_payment' => $tpPayment,
        'ds_observations' => null,
      ]);

      throw_if($vlPaid > $obAccount->vl_balance, "Título Nº $sAccountMovement[ds_title] - Valor de Baixa excede o Saldo Restante");

      $obAccount->vl_balance = $obAccount->vl_balance - $vlPaid;

      if ($obAccount->vl_balance <= 0) {
        $obAccount->tp_status = AccountGeneralStatusEnum::PAID->value;
        $obAccount->da_settlement = now();
      }

      $obAccount->save();
    }

    return ResponseHelper::success();
  }

  public function storePaymentReversal(Request $request)
  {
    $idAccount = $request->account_id;
    $idAccountMovement = $request->account_movement_id;
    $tpAccount = $request->tp_account;

    $accountClass = $tpAccount === 'receivable' ? AccountReceivable::class : AccountPayable::class;
    $accountForeignField = $tpAccount === 'receivable' ? 'account_receivable_id' : 'account_payable_id';
    $accountMovementClass = $tpAccount === 'receivable' ? AccountReceivableMovement::class : AccountPayableMovement::class;

    $obAccount = $accountClass::findOrFail($idAccount);
    $obAccountMovement = $accountMovementClass::findOrFail($idAccountMovement);

    throw_if($obAccountMovement->tp_movement === AccountGeneralMovementEnum::REVERSE->value, 'Movimentações de Estorno não podem ser estornadas');
    throw_if($obAccountMovement->fl_blocked, 'A movimentação selecionada já possui Estorno');

    $accountMovementClass::create([
      $accountForeignField => $obAccount->id,
      'vl_movement' => $obAccountMovement->vl_movement,
      'vl_discount' => $obAccountMovement->vl_discount,
      'da_movement' => now(),
      'tp_movement' => AccountGeneralMovementEnum::REVERSE->value,
      'tp_payment' => $obAccountMovement->tp_payment,
      'fl_blocked' => true,
      'ds_observations' => $obAccountMovement->ds_observations,
    ]);

    $obAccount->update([
      'vl_balance' => $obAccount->vl_balance + $obAccountMovement->vl_movement,
    ]);

    $obAccountMovement->update([
      'fl_blocked' => true,
    ]);

    return ResponseHelper::success();
  }
}
