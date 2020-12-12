<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'account_id', 'name', 'profile', 'email', 'password', 'image_name', 'pre_register_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'follows_count',
        // 'follows_id',
        'followers_count',
        // 'followers_id',
        'success_rate',
        'reviews_count',
        // 'done_id',
        'wannas_count',
        // 'wanna_id',
        'like_reviews_count',
        'like_reviews_id',
    ];

    protected $with = [];
    
    public function reviews() {
        return $this->hasMany('\App\Models\Review');
    }

    public function follows() {
        return $this->belongsToMany(self::class, "\App\Models\Follow", "following_id", "followed_id");
    }

    public function followers() {
        return $this->belongsToMany(self::class, "\App\Models\Follow", "followed_id", "following_id");
    }

    public function wannas() {
        return $this->hasMany('\App\Models\Wanna');
    }

    public function review_comments() {
        return $this->hasMany('\App\Models\ReviewComment');
    }

    public function accompanies() {
        return $this->hasMany('\App\Models\Accompany');
    }

    public function review_likes() {
        return $this->hasMany('\App\Models\ReviewLike');
    }

    public function getFollowsCountAttribute() {
        return $this->follows()->count();
    }
    
    public function getFollowsIdAttribute() {
        $follows = $this->follows->map(function ($item, $key) {
            return $item->id;
        });

        return $follows->all();
    }
    
    public function getFollowersCountAttribute() {
        return $this->followers()->count();
    }

    public function getFollowersIdAttribute() {
        $followers = $this->followers->map(function ($item, $key) {
            return $item->id;
        });

        return $followers->all();
    }

    public function getSuccessRateAttribute() {
        $reviews = $this->reviews()->count();
        $na = $this->reviews()->whereResult(0)->count();
        $success = $this->reviews()->whereResult(1)->count();
        $fail = $this->reviews()->whereResult(2)->count();

        if ($reviews === $na) {
            return null;
        }

        if ($success === 0) {
            return 0;
        }

        return $success / $reviews;
    }

    public function getReviewsCountAttribute() {
        return $this->reviews()->count();
    }

    public function getDoneIdAttribute() {
        $done_id = [];
        foreach ($this->reviews as $review) {
            $done_id[] = $review->product_id;
        }
        return $done_id;
    }

    public function getWannasCountAttribute() {
        return $this->wannas()->count();
    }

    public function getWannaIdAttribute() {
        $wanna_id = [];
        foreach ($this->wannas as $wanna) {
            $wanna_id[] = $wanna->product_id;
        }
        return $wanna_id;
    }

    public function getLikeReviewsCountAttribute() {
        return $this->review_likes()->count();
    }

    public function getLikeReviewsIdAttribute() {
        $review_likes_id = [];
        foreach ($this->review_likes as $review_like) {
            $review_likes_id[] = $review_like->review_id;
        }
        return $review_likes_id;
    }
}
