<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, Notifiable;

  protected $fillable = [
    'name',
    'email',
    'password',
    'profile_id',
    'company_id',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  public static function current(string|false $attribute = false)
  {
    $user = auth()->guard('sanctum')->user();

    if (!$user) {
      return null;
    }

    if ($attribute) {
      return data_get($user, $attribute); // acessa nested properties usando '->'
    }

    return $user;
  }
}
