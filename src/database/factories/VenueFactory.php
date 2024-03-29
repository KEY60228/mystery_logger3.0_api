<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Venue;
use App\Models\Organizer;
use Faker\Generator as Faker;

$factory->define(Venue::class, function (Faker $faker) {
    return [
        'organizer_id' => factory(Organizer::class)->create()->id,
        'name' => $faker->text,
        'kana_name' => $faker->text,
        'zipcode' => $faker->postcode,
        'addr_pref_id' => rand(1, 47),
        'addr_prefecture' => $faker->city,
        'addr_city' => $faker->address,
        'addr_block' => $faker->streetName,
        'addr_building' => $faker->buildingNumber,
        'lat' => $faker->latitude,
        'long' => $faker->longitude,
        'tel' => $faker->phoneNumber,
    ];
});
