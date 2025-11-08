<?php

namespace App\Http\Controllers;

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
    return ResponseHelper::success(data: AccountMovement::allMovements($request));
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
        'tp_payment' => $tpPayment,
        'ds_observations' => null,
      ]);

      throw_if($vlPaid > $obAccount->vl_balance, "Título Nº $sAccountMovement[ds_title] - Valor de Baixa excede o Saldo Restante");

      $obAccount->vl_balance = $obAccount->vl_balance - $vlPaid;

      if ($obAccount->vl_balance <= 0) {
        $obAccount->tp_status = AccountGeneralStatusEnum::PAID->value;
      }

      $obAccount->save();
    }

    return ResponseHelper::success();
  }
}
