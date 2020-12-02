<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    protected $guarded = [];
    
    public function venue() {
        return $this->belongsTo('\App\Models\Venue');
    }

    public function product() {
        return $this->belongsTo('\App\Models\Product');
    }
}
