<?php
namespace App\Services;

use App\Core\Service;
use App\Models\User;

class UserService extends Service
{
  protected string $model = User::class;
}