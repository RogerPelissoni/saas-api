<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resource;
use App\Models\Profile;

class ProfileController extends Controller
{
  protected string $model = Profile::class;

  public function getPermissionsByProfile(Request $request)
  {
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

    return response()->json([
      'data' => $obProfilePermission,
    ]);
  }
}
