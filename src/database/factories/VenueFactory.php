<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Venue;
use Faker\Generator as Faker;

$factory->define(Venue::class, function (Faker $faker) {
    return [
        'name' => $faker->text,
        'address' => $faker->address,
        'tel' => $faker->phoneNumber,
        'organizer_id' => $faker->randomDigitNotNull,
    ];
});
