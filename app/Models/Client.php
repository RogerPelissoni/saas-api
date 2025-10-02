<?php

namespace App\Models;

use App\Http\Controllers\Model;

class Client extends Model
{
  protected $table = 'client';
  protected $fillable = [
    'name',
  ];
}
