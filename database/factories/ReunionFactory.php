<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Reunion;
use App\Academia;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Reunion::class, function (Faker $faker) {
    $horas = $faker->numberBetween($min = -240, $max = 240);
    $inicio = Carbon::now()->addHours($horas);
    $fin = $inicio->addHour();
    $academias = Academia::all()->pluck('id');
    return [
        "academia_id" => $faker->randomElement($academias),
        "lugar" => "Sala de Juntas",
        "inicio" => $inicio,
        "fin" => $fin,
        "orden_del_dia" => null,
        "minuta" => null,
        "created_at" => Carbon::now(),
        "updated_at" => Carbon::now(),
    ];
});
