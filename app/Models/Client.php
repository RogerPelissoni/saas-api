<?php

namespace App\Models;

use App\Models\Relations\PersonRelation;
use Core\Model;

class Client extends Model
{
  use PersonRelation;

  public static string $kvKey = 'id';
  public static array $kvValues = ['person.name'];

  protected $table = 'client';
  protected $fillable = [
    'person_id',
    'da_registration',
  ];

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->appends = array_merge($this->appends, PersonRelation::appends());
  }

  public static function getBindFilters(): array
  {
    return [
      ...PersonRelation::bindFilters(),
    ];
  }
}
