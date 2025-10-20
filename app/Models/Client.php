<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Core\Models\Person;
use Core\Model;

class Client extends Model
{
  public static string $kvKey = 'id';
  public static array $kvValues = ['person.name'];

  protected $table = 'client';
  protected $fillable = [
    'person_id',
    'da_registration',
  ];

  // Relations
  public function person(): BelongsTo
  {
    return $this->belongsTo(Person::class);
  }
}
