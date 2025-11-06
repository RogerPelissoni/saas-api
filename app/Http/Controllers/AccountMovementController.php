<?php

namespace App\Http\Controllers;

use Core\Helpers\ResponseHelper;
use App\Models\AccountMovement;
use Illuminate\Http\Request;

class AccountMovementController
{
  public function index(Request $request)
  {
    return ResponseHelper::success(data: AccountMovement::allMovements($request));
  }
}
