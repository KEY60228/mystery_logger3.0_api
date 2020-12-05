<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accompany extends Model
{
    public $guarded = [];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function performance() {
        return $this->belongsTo('App\Models\Performance');
    }
}
