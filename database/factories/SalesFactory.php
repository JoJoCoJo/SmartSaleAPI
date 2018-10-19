<?php

use Faker\Generator as Faker;
use App\Sale;

$factory->define(Sale::class, function (Faker $faker) {
    return [
        'date_sale' => $faker->date('Y-m-d', 'now'),
        'units_sales' => $faker->numberBetween(1, 500),
        'type_sale' => $faker->numberBetween(1, 3),
        'user_id' => $faker->numberBetween(1, 50),
        'category_id' => $faker->numberBetween(1, 10),
    ];
});
