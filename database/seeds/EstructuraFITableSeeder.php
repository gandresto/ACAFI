<?php

use Illuminate\Database\Seeder;

class EstructuraFITableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 50)->create();

        factory(App\Division::class, 5)->create()->each(function ($division) {
            $division->departamentos()
                        ->saveMany(factory(App\Departamento::class, 4)->make());
        });

        $users=App\User::all();

        App\Division::all()->each(function ($division) use ($users) {
            $num_jefes = 4;
            //Seleccionar 4 usuarios al azar
            $jefes_rand = $users->random($num_jefes)->pluck('id')->toArray();
            //Jefe Activo
            $division->jefes()->attach($jefes_rand[0]);
            //Jefes inactivos
            for ($i=0; $i < $num_jefes; $i++) {
                $division->jefes()->attach(
                    array($jefes_rand[$i] => ['actual' => false])
                );
            }
        });
    }
}
