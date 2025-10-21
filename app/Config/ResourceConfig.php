<?php
namespace App\Config;

use Core\Config\ResourceConfigCore;

class ResourceConfig extends ResourceConfigCore
{
  protected static function resources(): array
  {
    return [
      ['name' => 'Clientes', 'signature' => 'client'],
      ['name' => 'Contas a Pagar', 'signature' => 'accountpayable'],
      ['name' => 'Contas a Receber', 'signature' => 'accountreceivable'],
      ['name' => 'Eventos de Calendário', 'signature' => 'event'],
      ['name' => 'Profissionais', 'signature' => 'professional'],
    ];
  }
}