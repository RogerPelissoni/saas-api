<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
  public function index()
  {
    return response()->json([
      'data' => Client::all(),
    ]);
  }

  public function store(Request $request)
  {
    Client::create([
      'name' => $request->name,
    ]);

    return response()->json([
      'message' => 'Operação efetuada com sucesso'
    ]);
  }

  public function show(string $id) {}

  public function update(Request $request, string $id) {}

  public function destroy(string $id) {}
}
