<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

//use App\Model;
//use Faker\Generator as Faker;

use App\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'price' =>20,
        'category' =>  $faker->name,
        'description' =>  $faker->sentence,
        'avatar' => $faker->sentence,
    ];
});
