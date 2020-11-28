<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('\App\Models\User');
    }

    public function review() {
        return $this->belongsTo('\App\Models\Review');
    }
}
