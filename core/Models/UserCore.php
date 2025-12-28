<?php

namespace Core\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Core\DTO\BindFilterDTO;

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

  protected $appends = [
    'ds_person',
    'ds_profile',
    'ds_company',
  ];

  public static function getBindFilters(): array
  {
    return [
      'ds_person' => new BindFilterDTO(relation: 'person', field: 'name'),
      'ds_profile' => new BindFilterDTO(relation: 'profile', field: 'name'),
      'ds_company' => new BindFilterDTO(relation: 'company', field: 'name'),
    ];
  }

  // Relations
  public function person(): BelongsTo
  {
    return $this->belongsTo(Person::class);
  }

  public function profile(): BelongsTo
  {
    return $this->belongsTo(Profile::class);
  }

  public function company(): BelongsTo
  {
    return $this->belongsTo(Company::class);
  }

  // Attributes
  public function getDsPersonAttribute()
  {
    return $this->person?->name;
  }

  public function getDsProfileAttribute()
  {
    return $this->profile?->name;
  }

  public function getDsCompanyAttribute()
  {
    return $this->company?->name;
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
