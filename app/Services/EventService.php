<?php
namespace App\Services;

use App\DTOs\StoreServiceOrderDTO;
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

    app(ServiceOrderService::class)->storeWithFinancial(new StoreServiceOrderDTO(
      idEvent: $obModel->id,
      idClient: $request->client_id,
      idProfessional: $request->professional_id,
      vlTotal: $request->vl_total,
      daDue: $request->da_due,
    ));

    return ResponseHelper::success(data: $obModel);
  }
}