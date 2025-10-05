<?php

namespace App\Http\Controllers;

use App\Core\Controller;
use App\Models\User;

class UserController extends Controller
{
  protected string $model = User::class;
}
