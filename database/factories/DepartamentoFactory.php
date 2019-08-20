<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Departamento;
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

$factory->define(Departamento::class, function (Faker $faker) {
    return [
        'nombre' => 'Departamento de '.$faker->word(),
        'jefe_dpto_id' => $faker->unique()->numberBetween($min = 2, $max = 50),
    ];
});
