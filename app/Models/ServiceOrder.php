<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Core\Model;

class ServiceOrder extends Model
{
  protected $table = 'service_order';
  protected $fillable = [
    'client_id',
    'professional_id',
    'account_receivable_id',
    'event_id',
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

  public function event(): BelongsTo
  {
    return $this->belongsTo(Event::class);
  }
}
