<?php

use Faker\Generator as Faker;

$factory->define(App\Stock::class, function (Faker $faker) {
    return [
        'goods_name' => $faker->name,
        'quantity' => rand(1, 10),
        'base_price' => rand(30, 50),
        'selling_price' => 30,
        'status' => 1,
        'notifications' => 1,
    ];
});
