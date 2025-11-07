<?php

namespace App\Models;

use Core\Model;

class AccountPayableMovement extends Model
{
  protected $table = 'account_payable_movement';
  protected $fillable = [
    'account_payable_id',
    'vl_movement',
    'vl_discount',
    'da_movement',
    'tp_payment',
    'ds_observations',
  ];
}
