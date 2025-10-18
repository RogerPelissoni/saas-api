<?php

namespace Core\Enums;

use Illuminate\Support\Arr;

enum PermissionLevelEnum: string
{
  case NONE = 'none';
  case READ = 'read';
  case WRITE = 'write';
  case DELETE = 'delete';
  case ADMIN = 'admin';

  public function label(): string
  {
    return match ($this) {
      self::NONE => 'Sem acesso',
      self::READ => 'Apenas visualização',
      self::WRITE => 'Criação e edição',
      self::DELETE => 'Exclusão',
      self::ADMIN => 'Acesso total',
    };
  }

  public function level(): int
  {
    return match ($this) {
      self::NONE => 0,
      self::READ => 1,
      self::WRITE => 2,
      self::DELETE => 3,
      self::ADMIN => 4,
    };
  }

  public function canAtLeast(self $required): bool
  {
    return $this->level() >= $required->level();
  }

  public static function values(): array
  {
    return Arr::pluck(self::cases(), 'value');
  }
}
