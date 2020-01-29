<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Acuerdo;
use App\Tema;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Acuerdo::class, function (Faker $faker) {
    $tema = Tema::all()->random();
    $responsable = $tema->reunion->academia->miembrosActuales->random();
    $resuelto = $faker->boolean($chanceOfGettingTrue = 30);
    $fecha_comprimiso = Carbon::now()->addDays(5);
    $fecha_resuelto = $resuelto ? Carbon::now() : null;
    $resultado = $resuelto ? $faker->sentence(9) : null;
    return [
        "descripcion" => $faker->sentence(6),
        "resuelto" => $resuelto,
        "resultado" => $resultado,
        "producto_esperado" => $faker->sentence(9),
        "fecha_compromiso" => $fecha_comprimiso,
        "fecha_resuelto" => $fecha_resuelto,
        "tema_id" => $tema->id,
        "responsable_id" => $responsable->id,
        "created_at" => Carbon::now()->addDays(-10),
        "updated_at" => Carbon::now(),
    ];
});
