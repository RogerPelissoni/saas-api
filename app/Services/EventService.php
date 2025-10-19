<?php
namespace App\Services;

use Core\Service;
use App\Models\Event;

class EventService extends Service
{
  protected string $model = Event::class;
}