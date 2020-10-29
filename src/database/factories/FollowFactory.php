<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Follow;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Follow::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'follow_user_id' => factory(User::class)->create()->id,
    ];
});
