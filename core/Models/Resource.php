<?php

namespace Core\Models;

use Core\Model;

class Resource extends Model
{
  protected $table = 'resource';
  protected $fillable = [
    'name',
    'signature',
  ];
}
