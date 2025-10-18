<?php

namespace Core\Models;

use Core\Model;

class Profile extends Model
{
  protected $table = 'profile';
  protected $fillable = [
    'name',
    'description',
  ];
}
