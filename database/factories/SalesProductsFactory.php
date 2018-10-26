<?php

use Faker\Generator as Faker;
use App\SalesProduct;

$factory->define(SalesProduct::class, function (Faker $faker) {
    return [
        'sale_id' => $faker->numberBetween(1, 500),
        'product_id' => $faker->numberBetween(1, 100),
        'units_sales_product' => $faker->numberBetween(1, 200),
    ];
});