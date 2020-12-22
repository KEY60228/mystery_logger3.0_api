<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accompany extends Model
{
    use SoftDeletes;

    public $guarded = [];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function performance() {
        return $this->belongsTo('App\Models\Performance');
    }
}
