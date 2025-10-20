<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Core\Models\Person;
use Core\Model;

class Professional extends Model
{
  public static string $kvKey = 'id';
  public static array $kvValues = ['person.name'];

  protected $table = 'professional';
  protected $fillable = [
    'person_id',
    'user_id',
    'pc_commission',
    'da_hire',
    'da_termination',
  ];

  // Relations
  public function person(): BelongsTo
  {
    return $this->belongsTo(Person::class);
  }
}
