<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Organizer;
use Faker\Generator as Faker;

$factory->define(Organizer::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'website' => $faker->url,
        'address' => $faker->address,
        'tel' => $faker->phoneNumber,
        'mail' => $faker->safeEmailDomain,
        'establish' => $faker->text,
    ];
});
