<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wanna extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('\App\Models\User');
    }

    public function product() {
        return $this->belongsTo('\App\Models\Product');
    }
}
