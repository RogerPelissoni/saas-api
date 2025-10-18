<?php

namespace Core\Models;

use Core\Model;

class Company extends Model
{
  protected $table = 'company';
  protected $fillable = [
    'name',
    'tp_company',
    'ds_email',
    'ds_phone',
    'ds_address',
  ];
}
