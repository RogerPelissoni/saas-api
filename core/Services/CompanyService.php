<?php
namespace Core\Services;

use Core\Service;
use Core\Models\Company;

class CompanyService extends Service
{
  protected string $model = Company::class;
}