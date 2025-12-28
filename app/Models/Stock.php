<?php

namespace App\Models;

use Core\DTO\BindFilterDTO;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Core\Model;

class Stock extends Model
{
  protected $table = 'stock';

  protected $fillable = [
    'product_id',
    'nr_quantity',
    'nr_minimun',
  ];

  protected $appends = [
    'ds_product'
  ];

  public static function getBindFilters(): array
  {
    return [
      'ds_product' => new BindFilterDTO(relation: 'product', field: 'name'),
    ];
  }

  // Relations
  public function product(): BelongsTo
  {
    return $this->belongsTo(Product::class);
  }

  // Attributes
  public function getDsProductAttribute()
  {
    return $this->product?->name;
  }
}
