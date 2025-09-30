<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
  public function register(Request $request)
  {
    $data = $request->validate([
      'name'     => 'required|string|max:255',
      'email'    => 'required|email|unique:users',
      'password' => 'required|min:6',
    ]);

    $user = User::create([
      'name'     => $data['name'],
      'email'    => $data['email'],
      'password' => Hash::make($data['password']),
    ]);

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
      'user'  => $user,
      'token' => $token,
    ], 201);
  }

  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email'    => ['required', 'email'],
      'password' => ['required'],
    ]);

    $user = User::where('email', $credentials['email'])->first();

    if (!$user || !Hash::check($credentials['password'], $user->password)) {
      return response()->json(['message' => 'Credenciais inválidas'], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
      'user'  => $user,
      'token' => $token,
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
}
