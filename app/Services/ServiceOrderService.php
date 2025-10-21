<?php
namespace App\Services;

use App\DTOs\StoreServiceOrderDTO;
use App\Models\ServiceOrder;
use App\Models\Client;
use Core\Service;

class ServiceOrderService extends Service
{
  protected string $model = ServiceOrder::class;

  public function storeWithFinancial(StoreServiceOrderDTO $dto): ServiceOrder
  {
    $obClient = Client::find($dto->idClient);

    $obAccountReceivable = app(AccountReceivableService::class)->storePending(
      $obClient->person_id,
      $dto->vlTotal,
      $dto->daDue,
    );

    $obModel = $this->model::create([
      'client_id' => $dto->idClient,
      'professional_id' => $dto->idProfessional,
      'account_receivable_id' => $obAccountReceivable->id,
      'event_id' => $dto->idEvent,
    ]);

    return $obModel;
  }
}