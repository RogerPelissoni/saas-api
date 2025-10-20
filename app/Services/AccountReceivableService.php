<?php
namespace App\Services;

use Core\Enums\AccountGeneralStatusEnum;
use App\Helpers\AccountGeneralHelper;
use App\Models\AccountReceivable;
use Core\Service;

class AccountReceivableService extends Service
{
  protected string $model = AccountReceivable::class;

  public function storePending(int $idPerson, float $vlTotal, ?string $daDue = null): AccountReceivable
  {
    $obAccountReceivable = $this->model::create([
      'person_id' => $idPerson,
      'ds_title' => AccountGeneralHelper::getNextTitle(),
      'nr_installment' => 1,
      'vl_total' => $vlTotal,
      'vl_balance' => $vlTotal,
      'da_due' => $daDue ?? now(),
      'da_received' => null,
      'tp_status' => AccountGeneralStatusEnum::PENDING->value,
      'ds_observations' => null,
    ]);

    return $obAccountReceivable;
  }
}