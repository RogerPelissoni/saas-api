<?php
namespace App\Services;

use App\Models\Product;
use Core\Service;

class ProductService extends Service
{
  protected string $model = Product::class;
}