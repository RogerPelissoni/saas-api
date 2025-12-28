<?php

namespace App\Models;

use Core\Model;

class StockMovement extends Model
{
  protected $table = 'stock_movement';

  protected $fillable = [
    'product_id',
    'nr_quantity',
    'tp_action',
  ];
}
