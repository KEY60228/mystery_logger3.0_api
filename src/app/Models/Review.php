<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
  const NO_ANSWER = 0;
  const SUCCESS = 1;
  const FAILED = 2;

  public $guarded = [];
}
