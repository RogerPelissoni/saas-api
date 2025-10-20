<?php

namespace App\Models;

use Core\Model;

class Event extends Model
{
  protected $table = 'event';
  protected $fillable = [
    'ds_title',
    'ds_description',
    'dt_start',
    'dt_end',
    'tp_status',
  ];
}
