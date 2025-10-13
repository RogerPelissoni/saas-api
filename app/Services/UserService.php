<?php
namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Core\QueryHelper;
use App\Core\Service;
use App\Models\User;

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
      'profile.name AS ds_profile',
      'company.name AS ds_company',
    ])
      ->join('profile', 'profile.id', '=', 'users.profile_id')
      ->leftJoin('company', 'company.id', '=', 'users.company_id');

    return QueryHelper::resolve($obModel, $request);
  }
}