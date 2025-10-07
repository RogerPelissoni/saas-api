<?php

namespace App\Models;

use App\Core\Model;

class Cliente extends Model
{
  protected $table = 'cliente';
  protected $fillable = [
    'name',
    'ds_email',
    'ds_telefone',
    'da_nascimento',
  ];
}
