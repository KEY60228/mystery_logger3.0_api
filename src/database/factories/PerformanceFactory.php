<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Performance;
use App\Models\Product;
use App\Models\Venue;
use Faker\Generator as Faker;

$factory->define(Performance::class, function (Faker $faker) {
    return [
        'product_id' => factory(Product::class)->create()->id,
        'venue_id' => factory(Venue::class)->create()->id,
        'active_id' => $faker->numberBetween(0, 1),
        'start_date' => $faker->date('Y-m-d'),
        'end_date' => $faker->date('Y-m-d'),
    ];
});
