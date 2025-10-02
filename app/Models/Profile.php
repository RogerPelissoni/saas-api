<?php

namespace App\Models;

use App\Http\Controllers\Model;

class Profile extends Model
{
  protected $table = 'profile';
  protected $fillable = [
    'name',
  ];
}
