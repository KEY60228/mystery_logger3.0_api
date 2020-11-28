<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ReviewLike;
use App\Models\User;
use App\Models\Review;
use Faker\Generator as Faker;

$factory->define(ReviewLike::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create(),
        'review_id' => factory(Review::class)->create(),
    ];
});
