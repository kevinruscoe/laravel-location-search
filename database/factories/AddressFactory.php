<?php

use Faker\Generator as Faker;
use KevinRuscoe\GeoHelpers\Point;

$factory->define(App\Address::class, function (Faker $faker) {
    return [
        'user_id' => App\User::inRandomOrder()->first()->id,
        'location' => new Point(
            $faker->randomFloat(5, 49.959999905, 58.6350001085),
            $faker->randomFloat(5, -7.57216793459, 1.68153079591)
        )
    ];
});
