<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::post('/register', function (Request $request) {
  $data = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'password' => 'required|min:6',
  ]);

  info($data);

  $user = User::create([
    'name' => $data['name'],
    'email' => $data['email'],
    'password' => Hash::make($data['password']),
  ]);

  $token = $user->createToken('api-token')->plainTextToken;

  return response()->json([
    'user'  => $user,
    'token' => $token,
  ], 201);
});

Route::post('/login', function (Request $request) {
  $credentials = $request->validate([
    'email'    => ['required', 'email'],
    'password' => ['required'],
  ]);

  if (!Auth::attempt($credentials)) {
    return response()->json(['message' => 'Credenciais inválidas'], 401);
  }

  $user  = Auth::user();
  $token = $user->createToken('api-token')->plainTextToken;

  return response()->json([
    'user'  => $user,
    'token' => $token,
  ]);
});

// Route::middleware('auth:sanctum')->group(function () {
Route::get('/me', fn(Request $request) => $request->user());

Route::post('/logout', function (Request $request) {
  $request->user()->currentAccessToken()->delete();
  return response()->json(['message' => 'Logout realizado com sucesso']);
});

Route::apiResources([
  'client'  => \App\Http\Controllers\Api\ClientController::class,
  // 'products' => \App\Http\Controllers\Api\ProductController::class,
  // 'orders'   => \App\Http\Controllers\Api\OrderController::class,
]);
// });
