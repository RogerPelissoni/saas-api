<?php
namespace App\Services;

use App\Core\Service;
use App\Models\Client;

class ClientService extends Service
{
  protected string $model = Client::class;
}