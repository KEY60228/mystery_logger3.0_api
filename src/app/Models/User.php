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

    protected $appends = ['reviews_count', 'success_rate', 'like_reviews_id'];
    
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

    public function comments() {
        return $this->hasMany('\App\Models\Comment');
    }

    public function review_likes() {
        return $this->hasMany('\App\Models\ReviewLike');
    }

    public function getFollowsIdAttribute() {
        $follows_id = [];
        foreach ($this->follows as $follow) {
            $follows_id[] = $follow->id;
        }
        return $follows_id;
    }

    public function getFollowersIdAttribute() {
        $followers_id = [];
        foreach ($this->followers as $follower) {
            $followers_id[] = $follower->id;
        }
        return $followers_id;
    }

    public function getReviewsCountAttribute() {
        return $this->reviews()->count();
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

    public function getDoneIdAttribute() {
        $done_id = [];
        foreach ($this->reviews as $review) {
            $done_id[] = $review->product_id;
        }
        return $done_id;
    }

    public function getWannaIdAttribute() {
        $wanna_id = [];
        foreach ($this->wannas as $wanna) {
            $wanna_id[] = $wanna->product_id;
        }
        return $wanna_id;
    }

    public function getLikeReviewsIdAttribute() {
        $review_likes_id = [];
        foreach ($this->review_likes as $review_like) {
            $review_likes_id[] = $review_like->review_id;
        }
        return $review_likes_id;
    }
}
