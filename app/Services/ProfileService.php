<?php
namespace App\Services;

use App\Models\ProfilePermission;

trait ProfileService
{
  protected function syncPermissions($idProfile, $arrPermissions): void
  {
    foreach ($arrPermissions ?? [] as $sPermission) {
      $idProfilePermission = $sPermission['profile_permission_id'];
      $permissionLevel = $sPermission['permission_level'];

      if ($idProfilePermission) {
        ProfilePermission::find($idProfilePermission)->update([
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