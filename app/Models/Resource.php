<?php

namespace App\Models;

use App\Core\Model;

class Resource extends Model
{
  protected $table = 'resource';
  protected $fillable = [
    'name',
    'signature',
  ];
}
