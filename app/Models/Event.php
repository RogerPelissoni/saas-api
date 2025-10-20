<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Core\Model;

class Event extends Model
{
  protected $table = 'event';
  protected $fillable = [
    'client_id',
    'professional_id',
    'account_receivable_id',
    'ds_title',
    'ds_description',
    'vl_price',
    'dt_start',
    'dt_end',
    'tp_status',
  ];

  // Relations
  public function client(): BelongsTo
  {
    return $this->belongsTo(Client::class);
  }

  public function professional(): BelongsTo
  {
    return $this->belongsTo(Professional::class);
  }

  public function accountReceivable(): BelongsTo
  {
    return $this->belongsTo(AccountReceivable::class);
  }
}
