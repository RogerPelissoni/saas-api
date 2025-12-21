<?php
namespace App\Services;

use App\Models\ProductCategory;
use Core\Service;

class ProductCategoryService extends Service
{
  protected string $model = ProductCategory::class;
}