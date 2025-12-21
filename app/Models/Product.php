<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Core\Model;

class Product extends Model
{
  protected $table = 'product';
  protected $fillable = [
    'product_category_id',
    'name',
    'ds_description',
    'vl_price',
    'ds_code',
    'fl_active',
  ];

  protected $appends = [
    'ds_product_category',
  ];

  // Relatios
  public function productCategory(): BelongsTo
  {
    return $this->belongsTo(ProductCategory::class);
  }

  // Attributes
  public function getDsProductCategoryAttribute()
  {
    return $this->productCategory?->name;
  }
}
