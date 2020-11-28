<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewLike extends Model
{
    protected $guarded = [];
    protected $appends = [];

    public function user() {
        return $this->belongsTo('\App\Models\User');
    }

    public function review() {
        return $this->belongsTo('\App\Models\Review');
    }
}
