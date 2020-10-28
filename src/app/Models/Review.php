<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
  use SoftDeletes;

  const NO_ANSWER = 0;
  const SUCCESS = 1;
  const FAILED = 2;

  protected $guarded = [];

  protected $casts = [
    'rating' => 'float',
  ];

  protected $dates = ['deleted_at'];

  public function user() {
    return $this->belongsTo('\App\Models\User');
  }

  public function product() {
    return $this->belongsTo('\App\Models\Product');
  }
}
