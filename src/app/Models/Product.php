<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $guarded = [];

  /**
   * 作品情報に紐付くレビュー
   */
  public function reviews() {
    return $this->hasMany('\App\Models\Review');
  }

  public function organizer() {
    return $this->belongsTo('\App\Models\Organizer');
  }

  public function performances() {
    return $this->hasMany('\App\Models\Performance');
  }

  public function category() {
    return $this->belongsTo('\App\Models\Category');
  }
}
