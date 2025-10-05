<?php

namespace App\Models;

use App\Core\Model;

class Client extends Model
{
  protected $table = 'client';
  protected $fillable = [
    'name',
  ];
}
