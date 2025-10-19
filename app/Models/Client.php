<?php

namespace App\Models;

use Core\Model;

class Client extends Model
{
  protected $table = 'client';
  protected $fillable = [
    'person_id',
    'da_registration',
  ];
}
