<?php

use Faker\Generator as Faker;
use App\Category;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->sentence(10),
        'user_id' => $faker->numberBetween(1, 50),
    ];
});
