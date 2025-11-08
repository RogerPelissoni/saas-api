<?php

namespace Core\Enums;

use Core\Support\CoreEnum;

enum PaymentEnum: string
{
  use CoreEnum;

  case MONEY = 'MONEY';
  case PIX = 'PIX';

  public function label(): string
  {
    return match ($this) {
      self::MONEY => 'Dinheiro',
      self::PIX => 'Pix',
    };
  }
}
