<?php

namespace Core\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserCore extends Authenticatable
{
  use HasApiTokens, Notifiable;

  protected static ?self $cachedUser = null;

  protected $fillable = [
    'name',
    'email',
    'password',
    'profile_id',
    'company_id',
    'person_id',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  // Relations
  public function profile(): BelongsTo
  {
    return $this->belongsTo(Profile::class);
  }

  // Aux
  public static function current(string|false $attribute = false)
  {
    if (self::$cachedUser === null) {
      self::$cachedUser = auth()->guard('sanctum')->user();
    }

    $user = self::$cachedUser;

    if (!$user)
      return null;

    return $attribute ? data_get($user, $attribute) : $user;
  }
}
