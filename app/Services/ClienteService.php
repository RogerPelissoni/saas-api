<?php
namespace App\Services;

use App\Core\Service;
use App\Models\Cliente;

class ClienteService extends Service
{
  protected string $model = Cliente::class;
}