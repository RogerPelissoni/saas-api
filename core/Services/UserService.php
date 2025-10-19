<?php
namespace Core\Services;

use Illuminate\Http\JsonResponse;
use Core\Helpers\ResponseHelper;
use Core\Helpers\QueryHelper;
use Illuminate\Http\Request;
use App\Models\User;
use Core\Service;

class UserService extends Service
{
  protected string $model = User::class;

  public function index(Request $request): JsonResponse
  {
    $obModel = $this->model::select([
      'users.id',
      'users.name',
      'users.email',
      'users.profile_id',
      'users.company_id',
      'users.person_id',
      'profile.name AS ds_profile',
      'company.name AS ds_company',
      'person.name AS ds_person',
    ])
      ->join('profile', 'profile.id', '=', 'users.profile_id')
      ->leftJoin('company', 'company.id', '=', 'users.company_id')
      ->leftJoin('person', 'person.id', '=', 'users.person_id');

    return QueryHelper::resolve($obModel, $request);
  }

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