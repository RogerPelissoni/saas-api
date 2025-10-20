<?php
namespace App\Services;

use Core\Service;
use App\Models\AccountReceivable;

class AccountReceivableService extends Service
{
  protected string $model = AccountReceivable::class;

  public static function getNextTitle(): int
  {
    return (AccountReceivable::max('ds_title') ?? 1) + 1;
  }
}