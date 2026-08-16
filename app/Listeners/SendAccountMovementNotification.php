<?php

namespace App\Listeners;

use App\Events\AccountMovementRegistered;
use App\Notifications\AccountMovementNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * ShouldQueue faz o Laravel empurrar este Listener para a fila (Redis)
 * em vez de executá-lo dentro do ciclo de vida da requisição HTTP.
 * O worker (container "queue-worker") é quem efetivamente processa isso.
 */
class SendAccountMovementNotification implements ShouldQueue
{
  public int $tries = 3;
  public int $backoff = 5;

  // Toda requisição POST/PUT/PATCH/DELETE roda dentro de uma DB::transaction
  // (ver Core\Middleware\TransactionMiddleware). Sem isso, o job seria
  // empurrado pra fila ANTES da transação commitar — se a transação desse
  // rollback depois (ex: outro item do loop falhou), o e-mail já teria
  // saído mesmo com os dados desfeitos no banco. afterCommit=true faz o
  // Laravel só enfileirar de fato depois que a transação commitar (e
  // cancela o dispatch se ela der rollback).
  public bool $afterCommit = true;

  public function handle(AccountMovementRegistered $event): void
  {
    $person = $event->account->person;

    if (!$person || !$person->ds_email) {
      return;
    }

    $person->notify(new AccountMovementNotification(
      $event->account,
      $event->accountMovement,
      $event->tpMovement,
    ));
  }
}