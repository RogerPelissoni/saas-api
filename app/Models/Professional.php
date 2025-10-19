<?php

namespace App\Models;

use Core\Model;

class Professional extends Model
{
  protected $table = 'professional';
  protected $fillable = [
    'person_id',
    'user_id',
    'pc_commission',
    'da_hire',
    'da_termination',
  ];
}
