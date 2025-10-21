<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Core\Models\Person;
use Core\Model;

class AccountReceivable extends Model
{
  protected $table = 'account_receivable';
  protected $fillable = [
    'person_id',
    'ds_title',
    'nr_installment',
    'vl_total',
    'vl_balance',
    'da_due',
    'da_settlement',
    'tp_status',
    'ds_observations',
  ];

  protected $appends = [
    'ds_person',
  ];

  public static array $bindFilters = [
    'ds_person' => [
      'relation' => 'person',
      'field' => 'name',
    ]
  ];

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
}
