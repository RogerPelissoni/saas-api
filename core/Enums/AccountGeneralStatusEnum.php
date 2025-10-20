<?php

namespace Core\Enums;

use Core\Support\CoreEnum;

enum AccountGeneralStatusEnum: string
{
  use CoreEnum;

  case PENDING = 'PENDING';
  case PAID = 'PAID';

  public function label(): string
  {
    return match ($this) {
      self::PENDING => 'Pendente',
      self::PAID => 'Pago',
    };
  }
}
