<?php
namespace App\Services;

use App\Models\ProfilePermission;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseHelper;
use App\Config\ResourceConfig;
use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\Profile;
use App\Core\Service;

class ProfileService extends Service
{
  protected string $model = Profile::class;

  public function getPermissionsByProfile(Request $request)
  {
    ResourceConfig::sync();

    $obProfilePermission = Resource::select([
      'profile_permission.id AS profile_permission_id',
      'profile_permission.permission_level',
      'resource.id AS resource_id',
      'resource.name AS ds_resource',
    ])
      ->leftJoin('profile_permission', function ($join) use ($request) {
        $join->on('profile_permission.resource_id', '=', 'resource.id')
          ->where('profile_permission.profile_id', $request->profile_id);
      })
      ->get();

    return ResponseHelper::success(data: $obProfilePermission);
  }

  public function store(Request $request): JsonResponse
  {
    $modelClass = $this->model;
    $fillableFields = (new $modelClass())->getFillable();

    $obModel = $modelClass::create($request->only($fillableFields));

    $this->syncPermissions($obModel->id, $request->permissions);

    return ResponseHelper::success(data: $obModel);
  }

  public function update(Request $request, $id): JsonResponse
  {
    $modelClass = $this->model;
    $idProfile = $id;

    $obModel = $modelClass::findOrFail($idProfile);
    $obModel->update($request->only($obModel->getFillable()));

    $this->syncPermissions($idProfile, $request->permissions);

    return ResponseHelper::success(data: $obModel);
  }

  private function syncPermissions($idProfile, $arrPermissions): void
  {
    foreach ($arrPermissions ?? [] as $sPermission) {
      $idProfilePermission = $sPermission['profile_permission_id'];
      $permissionLevel = $sPermission['permission_level'];

      if ($idProfilePermission) {
        ProfilePermission::findOrFail($idProfilePermission)->update([
          'permission_level' => $permissionLevel ?? 1,
        ]);
      } else {
        $idResource = $sPermission['resource_id'];

        ProfilePermission::create([
          'profile_id' => $idProfile,
          'resource_id' => $idResource,
          'permission_level' => $permissionLevel ?? 1,
        ]);
      }
    }
  }
}