<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(),
        'description' => $faker->text(191),
        'is_approved' => $faker->boolean,
        'price' => $faker->randomFloat(2,0,2000),
    ];
});
