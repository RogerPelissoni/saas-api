<?php

namespace App\Models;

use App\Http\Controllers\Model;

class Resource extends Model
{
  protected $table = 'resource';
  protected $fillable = [
    'name',
    'resource',
  ];
}
