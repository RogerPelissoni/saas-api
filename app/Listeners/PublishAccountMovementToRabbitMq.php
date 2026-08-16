<?php

namespace App\Listeners;

use App\Events\AccountMovementRegistered;
use App\Services\RabbitMq\RabbitMqConnectionFactory;
use Illuminate\Contracts\Queue\ShouldQueue;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Segundo Listener do MESMO evento AccountMovementRegistered — não mexe em
 * nada do SendAccountMovementNotification. Publica a baixa como uma
 * mensagem no RabbitMQ, pra que qualquer serviço externo (em qualquer
 * linguagem) possa reagir sem acoplamento nenhum com este código Laravel.
 * Veja o consumidor de exemplo em ../../../saas-invoice-service.
 */
class PublishAccountMovementToRabbitMq implements ShouldQueue
{
  public int $tries = 3;
  public int $backoff = 5;

  // Mesmo motivo do SendAccountMovementNotification: não publicar no
  // RabbitMQ antes da transação da requisição commitar de verdade.
  public bool $afterCommit = true;

  public function handle(AccountMovementRegistered $event): void
  {
    $person = $event->account->person;

    $connection = RabbitMqConnectionFactory::connection();
    $channel = $connection->channel();

    $exchange = config('services.rabbitmq.exchanges.account_movements');

    $channel->exchange_declare(
      exchange: $exchange,
      type: 'topic',
      durable: true,
      auto_delete: false,
    );

    $payload = json_encode([
      'account_movement_id' => $event->accountMovement->id,
      'account_id' => $event->account->id,
      'tp_movement' => $event->tpMovement,
      'title' => $event->account->ds_title,
      'amount' => (float) $event->accountMovement->vl_movement,
      'balance' => (float) $event->account->vl_balance,
      'person_name' => $person?->name,
      'person_email' => $person?->ds_email,
      'occurred_at' => now()->toIso8601String(),
    ]);

    $message = new AMQPMessage($payload, [
      'content_type' => 'application/json',
      'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT,
    ]);

    // Routing key que o saas-invoice-service espera (bind: "account_movement.*").
    $channel->basic_publish($message, $exchange, 'account_movement.registered');

    $channel->close();
    $connection->close();
  }
}
