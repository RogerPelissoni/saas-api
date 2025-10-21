<?php

namespace App\Models\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Core\Models\Person;

trait PersonRelation
{
  // Relations
  public function person(): BelongsTo
  {
    return $this->belongsTo(Person::class);
  }

  // Attributes
  public function getDsPersonAttribute()
  {
    return $this->person?->name;
  }

  public static function appends(): array
  {
    return ['ds_person'];
  }

  // Aux
  public static function bindFilters(): array
  {
    return [
      'ds_person' => ['relation' => 'person', 'field' => 'name']
    ];
  }
}
