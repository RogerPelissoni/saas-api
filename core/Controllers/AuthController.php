<?php

namespace Core\Controllers;

use Illuminate\Support\Facades\Hash;
use Core\Models\ProfilePermission;
use Illuminate\Http\Request;
use Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    $data = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users',
      'password' => 'required|min:6',
    ]);

    $user = User::create([
      'name' => $data['name'],
      'email' => $data['email'],
      'password' => Hash::make($data['password']),
    ]);

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
      'user' => $user,
      'token' => $token,
    ], 201);
  }

  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email' => ['required', 'email'],
      'password' => ['required'],
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
      return response()->json(['message' => 'Credenciais inválidas'], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
      'user' => $user,
      'token' => $token,
      'permissions' => $this->getProfilePermissions($user->profile_id, $user->company_id),
    ]);
  }

  public function me(Request $request)
  {
    return response()->json($request->user());
  }

  public function logout(Request $request)
  {
    $request->user()->currentAccessToken()->delete();
    return response()->json(['message' => 'Logout realizado com sucesso']);
  }

  private function getProfilePermissions($idProfile, $idCompany)
  {
    $obProfilePermission = ProfilePermission::select([
      'resource.signature',
      'profile_permission.permission_level',
    ])
      ->join('resource', 'resource.id', '=', 'profile_permission.resource_id')
      ->where('profile_id', $idProfile);

    if ($idCompany) {
      $obProfilePermission->where('profile_permission.company_id', $idCompany);
    }

    return $obProfilePermission->pluck('permission_level', 'signature');
  }
}
