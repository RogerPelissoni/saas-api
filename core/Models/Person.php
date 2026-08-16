<?php

namespace Core\Models;

use Core\Model;
use Illuminate\Notifications\Notifiable;

class Person extends Model
{
  use Notifiable;

  protected $table = 'person';
  protected $fillable = [
    'name',
    'ds_document',
    'ds_email',
    'ds_phone',
    'da_birth',
    'tp_gender',
    'ds_address_street',
    'ds_address_number',
    'ds_address_complement',
    'ds_address_district',
    'ds_address_city',
    'ds_address_state',
    'ds_address_zipcode',
    'fl_active',
  ];

  // A coluna de e-mail é ds_email, não email, então precisamos dizer
  // explicitamente ao canal "mail" das Notifications pra onde enviar.
  public function routeNotificationForMail(): ?string
  {
    return $this->ds_email;
  }
}
