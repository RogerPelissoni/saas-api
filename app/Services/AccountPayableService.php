<?php
namespace App\Services;

use App\Models\AccountPayable;
use Core\Service;

class AccountPayableService extends Service
{
  protected string $model = AccountPayable::class;
}