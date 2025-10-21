<?php
namespace Core\Helpers;

class CoreHelper
{
  public static function isTrue(mixed $value): bool
  {
    if (is_bool($value)) {
      return $value;
    }

    if (is_numeric($value)) {
      return (int) $value === 1;
    }

    if (is_string($value)) {
      $normalized = strtolower(trim($value));

      $trueValues = ['1', 'true', 'yes', 'on', 'y'];
      $falseValues = ['0', 'false', 'no', 'off', 'n', ''];

      if (in_array($normalized, $trueValues, true)) {
        return true;
      }

      if (in_array($normalized, $falseValues, true)) {
        return false;
      }

      return (bool) $normalized;
    }

    return (bool) $value;
  }
}
