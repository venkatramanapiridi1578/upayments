<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Cart;
use Faker\Generator as Faker;

$factory->define(Cart::class, function (Faker $faker) {
    return [
        'session_id' => $faker->randomNumber(5, true),       
        'product_id' =>  $faker->randomDigitNotNull,
        'qty' =>  $faker->randomDigitNotNull
    ];
});
