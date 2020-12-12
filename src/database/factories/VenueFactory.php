<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Venue;
use Faker\Generator as Faker;

$factory->define(Venue::class, function (Faker $faker) {
    return [
        'organizer_id' => $faker->randomDigitNotNull,
        'name' => $faker->text,
        'kana_name' => $faker->text,
        'zipcode' => $faker->postcode,
        'addr_prefecture' => $faker->city,
        'addr_city' => $faker->address,
        'addr_block' => $faker->streetName,
        'addr_building' => $faker->buildingNumber,
        'lat' => $faker->latitude,
        'long' => $faker->longitude,
        'tel' => $faker->phoneNumber,
    ];
});
