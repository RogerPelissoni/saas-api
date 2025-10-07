<?php
namespace App\Services;

use App\Core\Service;
use App\Models\Company;

class CompanyService extends Service
{
  protected string $model = Company::class;
}