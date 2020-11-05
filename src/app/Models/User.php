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

    /**
     * ユーザー情報に紐付くレビューを取得
     */
    public function reviews() {
        return $this->hasMany('\App\Models\Review');
    }

    public function follows() {
        return $this->belongsToMany(self::class, "\App\Models\Follow", "following_id", "followed_id");
    }

    public function followers() {
        return $this->belongsToMany(self::class, "\App\Models\Follow", "followed_id", "following_id");
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
}
