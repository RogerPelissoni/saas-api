<?php

namespace App\Events;

use App\Models\AccountPayable;
use App\Models\AccountPayableMovement;
use App\Models\AccountReceivable;
use App\Models\AccountReceivableMovement;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Disparado quando uma baixa (pagamento/recebimento) é registrada em um
 * título de AccountReceivable ou AccountPayable.
 *
 * Este evento é o ponto de entrada para tudo que pode acontecer de forma
 * assíncrona após uma baixa: notificar o cliente, gerar comprovante,
 * atualizar relatórios, etc. Quem reage a ele são os Listeners.
 */
class AccountMovementRegistered
{
  use Dispatchable, SerializesModels;

  public function __construct(
    public readonly AccountReceivableMovement|AccountPayableMovement $accountMovement,
    public readonly AccountReceivable|AccountPayable $account,
    public readonly string $tpMovement, // 'receivable' | 'payable'
  ) {}
}
