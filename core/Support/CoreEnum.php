<?php

namespace Core\Support;

trait CoreEnum
{
  public static function getValues(): array
  {
    return array_map(fn($case) => $case->value, self::cases());
  }

  public static function getLabels(): array
  {
    return array_map(fn($case) => $case->label(), self::cases());
  }

  public static function getOptions(): array
  {
    return array_combine(self::getValues(), self::getLabels());
  }
}
