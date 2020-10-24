<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
  const NO_ANSWER = 0;
  const SUCCESS = 1;
  const FAILED = 2;

  protected $guarded = [];

  protected $casts = [
    'rating' => 'float',
  ];

  public function user() {
    return $this->belongsTo('\App\Models\User');
  }

  public function product() {
    return $this->belongsTo('\App\Models\Product');
  }
}
