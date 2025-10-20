<?php
namespace App\Services;

use Core\Enums\AccountGeneralStatusEnum;
use App\Models\AccountReceivable;
use Illuminate\Http\JsonResponse;
use Core\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use App\Models\Event;
use Core\Service;

class EventService extends Service
{
  protected string $model = Event::class;

  public function store(Request $request): JsonResponse
  {
    $modelClass = $this->model;
    $fillableFields = (new $modelClass())->getFillable();

    $obModel = $modelClass::create($request->only($fillableFields));

    AccountReceivable::create([
      'person_id' => $obModel->client->person_id,
      'ds_title' => AccountReceivableService::getNextTitle(),
      'nr_installment' => 1,
      'vl_total' => $obModel->vl_price,
      'vl_balance' => $obModel->vl_price,
      'da_due' => now(),
      'da_received' => null,
      'tp_status' => AccountGeneralStatusEnum::PENDING->value,
      'ds_observations' => null,
    ]);

    return ResponseHelper::success(data: $obModel);
  }
}