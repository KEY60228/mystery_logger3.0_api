<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Review;
use App\Models\User;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'product_id' => factory(Product::class)->create()->id,
        'spoil' => $faker->boolean,
        'contents' => $faker->text,
        'result' => $faker->numberBetween(0, 2),
        'rating' => $faker->numberBetween(1, 5),
        'joined_at' => $faker->date('Y-m-d'),
    ];
});
