<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Division;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

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

$factory->define(Division::class, function (Faker $faker) {
    return [
        'siglas' => 'D'.strtoupper(Str::random(3)),
        'nombre' => 'Division de '.$faker->word(),
        'url' => $faker->url,
        'logo' => '/storage/' . Str::random(10) . '.png',
        #'jefe_div_id' => $faker->unique()->numberBetween($min = 2, $max = 50),
    ];
});
