<?php

use Faker\Generator as Faker;

$factory->define(App\PaymentAttempt::class, function (Faker $faker) {
    return [
        'order_id' => function () {
            return factory(\App\Order::class)->create()->id;
        },
        'status' => 1,
        'response_headers' => [],
        'response_body' => json_encode([
            'returnCode' => "SUCCESS",
            'trazabilityCode' => "1369787",
            'transactionID' => 1453092130
        ])
    ];
});
