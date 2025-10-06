<?php
namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use App\Enums\PermissionLevelEnum;
use App\Models\ProfilePermission;
use Illuminate\Http\Request;
use App\Models\User;
use Closure;

class RouteAccessMiddleware
{
  public function handle(Request $request, Closure $next): Response
  {
    $nmSignature = str_replace('api/', '', $request->route()->uri());

    self::checkAccess($request, $nmSignature);
    return $next($request);
  }

  public static function checkAccess(Request $request, string $nmSignature): void
  {
    $obUser = User::current();

    if ($nmSignature === 'multiple') {
      foreach ($request->signatures as $signParams) {
        $multipleSignature = $signParams['signature'];

        $permissionLevel = self::getPermissionLevel($obUser, $multipleSignature);
        self::hasPermissionToRead($permissionLevel, $multipleSignature);
      }
    } else {
      $permissionLevel = self::getPermissionLevel($obUser, $nmSignature);
      self::hasPermissionToRead($permissionLevel, $nmSignature);
    }
  }

  private static function getPermissionLevel(User $obUser, $nmSignature)
  {
    $mainSignature = explode('/', $nmSignature)[0] ?? $nmSignature;

    $permissionLevel = ProfilePermission::join('resource', 'resource.id', '=', 'profile_permission.resource_id')
      ->where('profile_permission.profile_id', $obUser->profile_id)
      ->where(
        fn($q) => $q->where('resource.signature', $mainSignature)
          ->orWhere('resource.signature', $nmSignature)
      )
      ->max('permission_level');

    return $permissionLevel ?? null;
  }

  private static function hasPermissionToRead($permissionLevel, $nmSignature): void
  {
    if ($permissionLevel < PermissionLevelEnum::READ->level()) {
      throw new \Exception("Permissão insuficiente para acessar o recurso $nmSignature");
    }
  }
}
