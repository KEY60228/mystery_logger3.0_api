<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Performance;
use Faker\Generator as Faker;

$factory->define(Performance::class, function (Faker $faker) {
    return [
        'product_id' => $faker->randomDigitNotNull,
        'venue_id' => $faker->randomDigitNotNull,
        'active_id' => $faker->numberBetween(0, 1),
        'start_date' => $faker->date('Y-m-d'),
        'end_date' => $faker->date('Y-m-d'),
    ];
});
