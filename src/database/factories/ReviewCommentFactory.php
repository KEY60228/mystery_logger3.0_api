<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ReviewComment;
use App\Models\User;
use App\Models\Review;
use Faker\Generator as Faker;

$factory->define(ReviewComment::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'review_id' => factory(Review::class)->create()->id,
        'contents' => $faker->text,
    ];
});
