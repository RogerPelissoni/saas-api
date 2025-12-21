<?php
namespace App\Config;

use Core\Config\ResourceConfigCore;

class ResourceConfig extends ResourceConfigCore
{
  protected static function resources(): array
  {
    return [
      ['name' => 'Clientes', 'signature' => 'client'],
      ['name' => 'Movimentações de Conta', 'signature' => 'accountmovement'],
      ['name' => 'Contas a Pagar', 'signature' => 'accountpayable'],
      ['name' => 'Contas a Receber', 'signature' => 'accountreceivable'],
      ['name' => 'Eventos de Calendário', 'signature' => 'event'],
      ['name' => 'Pedidos', 'signature' => 'order'],
      ['name' => 'Produtos', 'signature' => 'product'],
      ['name' => 'Produtos - Categorias', 'signature' => 'productcategory'],
      ['name' => 'Profissionais', 'signature' => 'professional'],
    ];
  }
}