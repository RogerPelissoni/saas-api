<?php

namespace Core\Enums;

use Core\Support\CoreEnum;

enum AccountGeneralMovementEnum: string
{
  use CoreEnum;

  case NORMAL = 'NORMAL';
  case REVERSE = 'REVERSE';

  public function label(): string
  {
    return match ($this) {
      self::NORMAL => 'Normal',
      self::REVERSE => 'Estorno',
    };
  }
}
