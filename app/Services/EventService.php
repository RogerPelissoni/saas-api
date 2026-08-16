<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\DTOs\StoreServiceOrderDTO;
use Illuminate\Http\JsonResponse;
use Core\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use Core\Helpers\CoreHelper;
use App\Models\Event;
use Core\Service;

class EventService extends Service
{
  protected string $model = Event::class;

  public function store(Request $request): JsonResponse
  {
    $flServiceOrder = CoreHelper::isTrue($request->fl_service_order);

    $modelClass = $this->model;
    $fillableFields = (new $modelClass())->getFillable();

    $obModel = DB::transaction(function () use ($modelClass, $fillableFields, $request, $flServiceOrder) {
      $obModel = $modelClass::create($request->only($fillableFields));

      if ($flServiceOrder) {
        app(ServiceOrderService::class)->storeWithFinancial(new StoreServiceOrderDTO(
          idEvent: $obModel->id,
          idClient: $request->client_id,
          idProfessional: $request->professional_id,
          vlTotal: $request->vl_total,
          daDue: $request->da_due,
        ));
      }

      return $obModel;
    });

    return ResponseHelper::success(data: $obModel);
  }
}