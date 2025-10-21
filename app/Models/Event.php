<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Core\Model;

class Event extends Model
{
  protected $table = 'event';
  protected $fillable = [
    'ds_title',
    'ds_description',
    'dt_start',
    'dt_end',
    'tp_status',
  ];

  protected $appends = [
    'fl_service_order',
    'client_id',
    'professional_id',
    'vl_total',
    'da_due',
  ];

  // Relations
  public function serviceOrder(): HasOne
  {
    return $this->hasOne(ServiceOrder::class);
  }

  // Appends
  public function getFlServiceOrderAttribute(): bool
  {
    return $this->relationLoaded('serviceOrder')
      ? $this->serviceOrder !== null
      : $this->serviceOrder()->exists();
  }

  public function getClientIdAttribute()
  {
    return $this->serviceOrder?->client_id;
  }

  public function getProfessionalIdAttribute()
  {
    return $this->serviceOrder?->professional_id;
  }

  public function getVlTotalAttribute()
  {
    return $this->serviceOrder?->accountReceivable?->vl_total;
  }

  public function getDaDueAttribute()
  {
    return $this->serviceOrder?->accountReceivable?->da_due;
  }
}
