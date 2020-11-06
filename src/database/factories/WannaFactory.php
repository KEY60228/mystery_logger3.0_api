<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Wanna;
use Faker\Generator as Faker;
use App\Models\User;
use App\Models\Product;

$factory->define(Wanna::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'product_id' => factory(Product::class)->create()->id,
    ];
});
