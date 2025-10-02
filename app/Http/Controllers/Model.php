<?php

namespace App\Http\Controllers;

abstract class Model extends \Illuminate\Database\Eloquent\Model
{
  public static string $kvKey = 'id';
  public static array $kvValues = ['name'];
}
