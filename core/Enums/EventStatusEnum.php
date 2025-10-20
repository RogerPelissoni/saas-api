<?php

namespace Core\Enums;

use Core\Support\CoreEnum;

enum EventStatusEnum: string
{
  use CoreEnum;

  case SCHEDULED = 'SCHEDULED';
  case DONE = 'DONE';
  case CANCELED = 'CANCELED';

  public function label(): string
  {
    return match ($this) {
      self::SCHEDULED => 'Agendado',
      self::DONE => 'Finalizado',
      self::CANCELED => 'Cancelado',
    };
  }
}
