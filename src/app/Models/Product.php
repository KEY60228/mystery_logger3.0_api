<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];
    protected $appends = [
        'avg_rating',
        'success_count',
        'na_count',
        'success_rate',
        'reviews_count',
        'wannas_count'
    ];
    protected $with = [];

    public function reviews() {
        return $this->hasMany('\App\Models\Review');
    }

    public function organizer() {
        return $this->belongsTo('\App\Models\Organizer');
    }

    public function performances() {
        return $this->hasMany('\App\Models\Performance');
    }

    public function category() {
        return $this->belongsTo('\App\Models\Category');
    }

    public function wannas() {
        return $this->hasMany('\App\Models\Wanna');
    }

    public function getAvgRatingAttribute() {
        $avgRating = $this->reviews()->avg('rating');
        if ($avgRating === 0 || null) {
            return null;
        } else {
            return round($avgRating, 2);
        }
    }

    public function getSuccessCountAttribute() {
        return $this->reviews()->where('result', 1)->count();
    }

    public function getNaCountAttribute() {
        return $this->reviews()->where('result', 0)->count();
    }

    public function getSuccessRateAttribute() {
        if ($this->reviews()->count() === $this->NACount) {
            return null;
        } else {
            return round(($this->success_count / ($this->reviews()->count() - $this->na_count)), 2);
        }
    }

    public function getReviewsCountAttribute() {
        return $this->reviews()->count();
    }

    public function getWannasCountAttribute() {
        return $this->wannas()->count();
    }
}
