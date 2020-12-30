<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Accompany;
use Faker\Generator as Faker;
use App\Models\User;
use App\Models\Performance;

$factory->define(Accompany::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)->create()->id,
        'performance_id' => factory(Performance::class)->create()->id,
        'contents' => $faker->word,
    ];
});
