<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    protected $guarded = [];
    
    public function products() {
        return $this->hasMany('\App\Models\Product');
    }

    public function venues() {
        return $this->hasMany('\App\Models\Venue');
    }
}
