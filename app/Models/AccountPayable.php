<?php

namespace App\Models;

use App\Models\Relations\PersonRelation;
use Core\Model;

class AccountPayable extends Model
{
  use PersonRelation;

  protected $table = 'account_payable';
  protected $fillable = [
    'person_id',
    'ds_title',
    'nr_installment',
    'vl_total',
    'vl_balance',
    'da_due',
    'da_settlement',
    'tp_status',
    'ds_observations',
  ];

  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
    $this->appends = array_merge($this->appends, PersonRelation::appends());
  }

  public static function getBindFilters(): array
  {
    return [
      ...PersonRelation::bindFilters(),
    ];
  }
}
