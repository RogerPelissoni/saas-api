<?php

namespace App\Models;

use Core\Model;

class ProductCategory extends Model
{
  protected $table = 'product_category';
  protected $fillable = [
    'name',
  ];
}
