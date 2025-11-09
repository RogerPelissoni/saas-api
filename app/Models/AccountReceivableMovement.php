<?php

namespace App\Models;

use Core\Model;

class AccountReceivableMovement extends Model
{
  protected $table = 'account_receivable_movement';
  protected $fillable = [
    'account_receivable_id',
    'vl_movement',
    'vl_discount',
    'da_movement',
    'tp_movement',
    'tp_payment',
    'fl_blocked',
    'ds_observations',
  ];
}
