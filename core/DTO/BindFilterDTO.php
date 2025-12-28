<?php
namespace Core\DTO;

final class BindFilterDTO
{
  public function __construct(
    public readonly string $relation,
    public readonly string $field,
  ) {
  }
}
