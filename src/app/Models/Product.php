<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
  protected $fillable = [
    'name', 'contents', 'image_name'
  ];

  /**
   * 作品情報に紐付くレビュー
   */
  public function reviews() {
    return $this->hasMany('\App\Models\Review');
  }
}
