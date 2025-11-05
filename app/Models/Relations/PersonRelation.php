<?php

namespace App\Models\Relations;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Core\Models\Person;

trait PersonRelation
{
  // Aux
  public static function appends(): array
  {
    return ['ds_person', 'ds_document', 'ds_address'];
  }

  public static function bindFilters(): array
  {
    return [
      'ds_person' => [
        'relation' => 'person',
        'field' => 'name'
      ],
      'ds_document' => [
        'relation' => 'person',
        'field' => 'ds_document'
      ],
      'ds_address' => [
        'relation' => 'person',
        'field' => [
          'ds_address_street',
          'ds_address_number',
          'ds_address_complement',
          'ds_address_district',
          'ds_address_city',
          'ds_address_state',
          'ds_address_zipcode',
        ]
      ],
    ];
  }

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

  public function getDsDocumentAttribute()
  {
    return $this->person?->ds_document;
  }

  public function getDsAddressAttribute()
  {
    return "{$this->person?->ds_address_street} {$this->person?->ds_address_number} {$this->person?->ds_address_complement} {$this->person?->ds_address_district} {$this->person?->ds_address_city} {$this->person?->ds_address_state} {$this->person?->ds_address_zipcode}";
  }
}
