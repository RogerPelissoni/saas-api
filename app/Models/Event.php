<?php

namespace App\Models;

use Core\Model;

class Event extends Model
{
  protected $table = 'event';
  protected $fillable = [
    'client_id',
    'professional_user_id',
    'account_receivable_id',
    'ds_title',
    'ds_description',
    'vl_price',
    'dt_start',
    'dt_end',
    'tp_status',
  ];
}
