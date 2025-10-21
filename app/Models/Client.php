<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Core\Models\Person;
use Core\Model;

class Client extends Model
{
  public static string $kvKey = 'id';
  public static array $kvValues = ['person.name'];

  protected $table = 'client';
  protected $fillable = [
    'person_id',
    'da_registration',
  ];

  protected $appends = [
    'ds_person',
  ];

  public static array $bindFilters = [
    'ds_person' => ['relation' => 'person', 'field' => 'name'],
  ];

  // Relations
  public function person(): BelongsTo
  {
    return $this->belongsTo(Person::class);
  }

  // Appends
  public function getDsPersonAttribute()
  {
    return $this->person?->name;
  }
}
