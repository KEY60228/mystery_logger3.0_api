<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\PreRegister;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Carbon\Carbon;

$factory->define(PreRegister::class, function (Faker $faker) {
    return [
        'email' => $faker->unique()->email,
        'token' => Str::random(250),
        'status' => $faker->numberBetween(0, 2),
        'expiration_time' => Carbon::now()->addHours(1),
    ];
});
