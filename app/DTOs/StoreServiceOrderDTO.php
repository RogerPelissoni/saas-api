<?php
namespace App\DTOs;

class StoreServiceOrderDTO
{
  public function __construct(
    public readonly int $idEvent,
    public readonly int $idClient,
    public readonly int $idProfessional,
    public readonly float $vlTotal,
    public readonly string $daDue,
  ) {
  }
}
