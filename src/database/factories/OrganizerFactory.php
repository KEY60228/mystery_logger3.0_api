<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Organizer;
use Faker\Generator as Faker;

$factory->define(Organizer::class, function (Faker $faker) {
    return [
        'service_name' => $faker->word,
        'kana_service_name' => $faker->word,
        'company_name' => $faker->word,
        'kana_company_name' => $faker->word,
        'website' => $faker->url,
        'image_name' => $faker->text,
        'zipcode' => $faker->postcode,
        'addr_prefecture' => $faker->city,
        'addr_city' => $faker->address,
        'addr_block' => $faker->streetName,
        'addr_building' => $faker->buildingNumber,
        'tel' => $faker->phoneNumber,
        'mail' => $faker->safeEmailDomain,
    ];
});
