<?php

use Faker\Generator as Faker;
use App\Forecast;

$factory->define(Forecast::class, function (Faker $faker) {
    return [
        'type_forecast' => $faker->numberBetween(1, 3),
        'forecastData' => json_encode(['title' => $faker->word, 'description' => $faker->sentence(10)]),
        'user_id' => $faker->numberBetween(1, 50),
        'sale_id' => $faker->numberBetween(1, 500)
    ];
});
