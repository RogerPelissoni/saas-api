<?php
namespace App\Helpers;

use App\Models\AccountReceivable;
use App\Models\AccountPayable;

class AccountGeneralHelper
{
  public static function getNextTitle(): int
  {
    $maxReceivable = AccountReceivable::max('ds_title') ?? 0;
    $maxPayable = AccountPayable::max('ds_title') ?? 0;

    return max($maxReceivable, $maxPayable) + 1;
  }
}