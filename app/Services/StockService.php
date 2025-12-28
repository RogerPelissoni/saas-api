<?php
namespace App\Services;

use Core\Service;
use App\Models\Stock;

class StockService extends Service
{
  protected string $model = Stock::class;
}