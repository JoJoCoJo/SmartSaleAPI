<?php

use Faker\Generator as Faker;
use App\Product;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'price' => $faker->randomFloat(2, 10, 500),
        'image' => $faker->imageUrl(100, 100),
        'user_id' => $faker->numberBetween(1, 50),
        'category_id' => $faker->numberBetween(1, 10)
    ];
});
