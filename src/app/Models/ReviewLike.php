<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewLike extends Model
{
    protected $guarded = [];
    protected $appends = [];

    public function user() {
        $this->belongsTo('\App\Models\User');
    }

    public function review() {
        $this->belongsTo('\App\Models\Review');
    }
}
