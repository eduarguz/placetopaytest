<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'email' => $faker->email,
        'amount' => random_int(1000, 100000),
        'quantity' => random_int(1, 10),
        'description' => $faker->sentence,
        'reference' => str_random(15)
    ];
});
