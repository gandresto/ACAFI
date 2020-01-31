<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Acuerdo;
use App\Tema;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Acuerdo::class, function (Faker $faker) {
    $tema = Tema::all()->random();
    $responsable = $tema->reunion->academia->miembrosActuales->random();
    $resuelto = $faker->boolean($chanceOfGettingTrue = 30);
    $fecha_comprimiso = Carbon::now()->addDays($faker->numberBetween(-7, 30));
    $fecha_finalizado = $resuelto ? Carbon::now() : null;
    $resultado = $resuelto ? $faker->sentence(9) : null;
    return [
        "descripcion" => $faker->sentence(6),
        "resultado" => $resultado,
        "producto_esperado" => $faker->sentence(9),
        "fecha_compromiso" => $fecha_comprimiso,
        "fecha_finalizado" => $fecha_finalizado,
        "tema_id" => $tema->id,
        "responsable_id" => $responsable->id,
        "created_at" => Carbon::now()->subDays(30),
        "updated_at" => Carbon::now(),
    ];
});
