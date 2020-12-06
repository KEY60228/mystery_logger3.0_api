<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use SoftDeletes;

    const NO_ANSWER = 0;
    const SUCCESS = 1;
    const FAILED = 2;

    protected $guarded = [];

    protected $casts = [
        'rating' => 'float',
    ];

    protected $appends = ['review_comments_count', 'review_likes_count'];

    protected $dates = ['deleted_at'];

    public function user() {
        return $this->belongsTo('\App\Models\User');
    }

    public function product() {
        return $this->belongsTo('\App\Models\Product');
    }

    public function review_comments() {
        return $this->hasMany('\App\Models\ReviewComment');
    }

    public function review_likes() {
        return $this->hasMany('\App\Models\ReviewLike');
    }

    public function getReviewCommentsCountAttribute() {
        return $this->review_comments()->count();
    }

    public function getReviewLikesCountAttribute() {
        return $this->review_likes()->count();
    }
}
