<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
    protected $guarded = [];
    
    public function performances() {
        return $this->hasMany('\App\Models\Performance');
    }

    public function organizer() {
        return $this->belongsTo('\App\Models\Organizer');
    }
}
