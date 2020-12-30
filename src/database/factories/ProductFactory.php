<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'organizer_id' => 1,
        'category_id' => 1,
        'name' => $faker->word,
        'kana_name' => $faker->word,
        'phrase' => $faker->sentence,
        'website' => $faker->url,
        'image_name' => $faker->text,
        'limitTime' => $faker->randomDigitNotNull,
        'requiredTime' => $faker->randomDigitNotNull,
        'minParty' => $faker->randomDigitNotNull,
        'maxParty' => $faker->randomDigitNotNull,
    ];
});
