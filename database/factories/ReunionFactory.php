<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reunion;
use App\Academia;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Reunion::class, function (Faker $faker) {
    $horas = $faker->numberBetween($min = -240, $max = 600);
    return [
        "lugar" => "Sala de Juntas",
        "inicio" => Carbon::now()->addHours($horas),
        "fin" => Carbon::now()->addHours($horas)->addHour(),
        "orden_del_dia" => null,
        "minuta" => null,
        "created_at" => Carbon::now(),
        "updated_at" => Carbon::now(),
    ];
});
