<?php
namespace App\Services;

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

    app(AccountReceivableService::class)->storePending(
      $obModel->client->person_id,
      $obModel->vl_price,
      $request->da_due
    );

    return ResponseHelper::success(data: $obModel);
  }
}