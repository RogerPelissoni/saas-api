<?php
namespace Core\Services;

use Core\Service;
use Core\Models\Person;

class PersonService extends Service
{
  protected string $model = Person::class;
}