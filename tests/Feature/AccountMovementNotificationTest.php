<?php

use App\Events\AccountMovementRegistered;
use App\Listeners\SendAccountMovementNotification;
use App\Models\AccountReceivable;
use App\Models\AccountReceivableMovement;
use App\Notifications\AccountMovementNotification;
use Core\Models\Person;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

// Estes testes não tocam o banco de dados de propósito: o objetivo aqui é
// validar a "cola" entre Event -> Listener (fila) -> Notification, que é
// justamente o mecanismo assíncrono que estamos estudando.

test('registrar uma baixa dispara o evento AccountMovementRegistered', function () {
  Event::fake();

  $account = new AccountReceivable(['ds_title' => 'NF 123', 'vl_balance' => 400]);
  $movement = new AccountReceivableMovement(['vl_movement' => 100]);

  event(new AccountMovementRegistered($movement, $account, 'receivable'));

  Event::assertDispatched(
    AccountMovementRegistered::class,
    fn($event) => $event->account === $account && $event->tpMovement === 'receivable'
  );
});

test('o listener roda em fila, não de forma síncrona', function () {
  expect(new SendAccountMovementNotification)->toBeInstanceOf(ShouldQueue::class);
});

test('o listener notifica por e-mail a pessoa vinculada à conta', function () {
  Notification::fake();

  $person = new Person(['name' => 'Cliente Teste', 'ds_email' => 'cliente@example.com']);
  $account = new AccountReceivable(['ds_title' => 'NF 123', 'vl_balance' => 300]);
  $account->setRelation('person', $person);
  $movement = new AccountReceivableMovement(['vl_movement' => 100]);

  (new SendAccountMovementNotification)->handle(
    new AccountMovementRegistered($movement, $account, 'receivable')
  );

  Notification::assertSentTo($person, AccountMovementNotification::class);
});

test('o listener não envia nada quando a pessoa não tem e-mail cadastrado', function () {
  Notification::fake();

  $person = new Person(['name' => 'Sem Email', 'ds_email' => null]);
  $account = new AccountReceivable(['ds_title' => 'NF 999', 'vl_balance' => 100]);
  $account->setRelation('person', $person);
  $movement = new AccountReceivableMovement(['vl_movement' => 50]);

  (new SendAccountMovementNotification)->handle(
    new AccountMovementRegistered($movement, $account, 'receivable')
  );

  Notification::assertNothingSent();
});
