<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reunion;
use App\Tema;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Tema::class, function (Faker $faker) {
    // $reuniones=Reunion::all()->pluck('id');
    return [
        "descripcion" => $faker->sentence(6),
        "comentario" => $faker->sentence(15),
        // "reunion_id" => $faker->randomElement($reuniones),
        "created_at" => Carbon::now(),
        "updated_at" => Carbon::now(),
    ];
});
