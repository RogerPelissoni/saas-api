<?php
namespace Core\Services;

use Illuminate\Http\JsonResponse;
use Core\Helpers\ResponseHelper;
use Illuminate\Http\Request;
use App\Models\User;
use Core\Service;

class UserService extends Service
{
  protected string $model = User::class;

  public function update(Request $request, $id): JsonResponse
  {
    $modelClass = $this->model;

    $obModel = $modelClass::findOrFail($id);
    $obUpdate = $request->only($obModel->getFillable());

    if (isset($obUpdate['password']) && !$obUpdate['password']) {
      unset($obUpdate['password']);
    }

    $obModel->update($obUpdate);

    return ResponseHelper::success(data: $obModel);
  }
}