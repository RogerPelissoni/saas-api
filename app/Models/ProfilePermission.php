<?php

namespace App\Models;

use App\Http\Controllers\Model;

class ProfilePermission extends Model
{
  protected $table = 'profile_permission';
  protected $fillable = [
    'profile_id',
    'resource_id',
    'permission_level',
  ];
}
