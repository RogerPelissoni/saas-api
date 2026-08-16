<?php

namespace App\Notifications;

use App\Models\AccountPayable;
use App\Models\AccountPayableMovement;
use App\Models\AccountReceivable;
use App\Models\AccountReceivableMovement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountMovementNotification extends Notification implements ShouldQueue
{
  use Queueable;

  public function __construct(
    public readonly AccountReceivable|AccountPayable $account,
    public readonly AccountReceivableMovement|AccountPayableMovement $accountMovement,
    public readonly string $tpMovement,
  ) {}

  public function via(object $notifiable): array
  {
    return ['mail'];
  }

  public function toMail(object $notifiable): MailMessage
  {
    $isReceivable = $this->tpMovement === 'receivable';

    return (new MailMessage)
      ->subject($isReceivable ? 'Pagamento recebido' : 'Pagamento efetuado')
      ->greeting("Olá, {$notifiable->name}!")
      ->line("Título: {$this->account->ds_title}")
      ->line('Valor da baixa: R$ ' . number_format($this->accountMovement->vl_movement, 2, ',', '.'))
      ->line('Saldo restante: R$ ' . number_format($this->account->vl_balance, 2, ',', '.'));
  }
}
