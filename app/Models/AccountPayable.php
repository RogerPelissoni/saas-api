<?php

namespace App\Models;

use Core\Model;

class AccountPayable extends Model
{
  protected $table = 'account_payable';
  protected $fillable = [
    'person_id',
    'ds_title',
    'nr_installment',
    'vl_total',
    'vl_balance',
    'da_due',
    'da_received',
    'tp_status',
    'ds_observations',
  ];
}
