<?php
namespace Core\Config;

abstract class PermissionConfigCore
{
  protected static function default(): array
  {
    return [];
  }

  protected static function defaultCore(): array
  {
    return [];
  }

  public static function getDefault($nmSignature = null): array|null
  {
    $merged = array_merge(static::default(), static::defaultCore());

    return $nmSignature
      ? $merged[$nmSignature] ?? null
      : $merged;
  }
}