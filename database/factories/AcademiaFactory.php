<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Academia;
use Faker\Generator as Faker;

$factory->define(Academia::class, function (Faker $faker) {
    return [
        'nombre' => implode(' ', $faker->words(3)),
    ];
});
