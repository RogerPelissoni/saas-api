<?php

namespace App\Models;

use App\Core\Model;

class Profile extends Model
{
  protected $table = 'profile';
  protected $fillable = [
    'name',
    'description',
  ];
}
