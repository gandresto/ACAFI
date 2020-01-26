<?php

use Carbon\Carbon;
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
        // ----------- Creamos divisiones, departamentos y academias. ---------------
        $num_jefes = 4;
        $num_miembros = 6;
        
        $users = App\User::all();
        $this->command->getOutput()->writeln("<info>Creando divisiones...</info>");
        factory(App\Division::class, 5)->create()
            ->each(function ($division)
            use ($users, $num_jefes, $num_miembros) {
                //Seleccionar 4 usuarios al azar para hacerlos jefes de division
                $jefes_rand = $users->random($num_jefes)->pluck('id')->toArray();
                //Jefe Activo (por defecto el jefe guardado es el actual)
                $division->jefes()->attach($jefes_rand[0]);
                //Jefes inactivos
                for ($i = $num_jefes-1; $i > 0; $i--) {
                    $division->jefes()->attach(
                        array($jefes_rand[$i] => [
                            'actual' => false,
                            'fecha_ingreso' => Carbon::now()->subMonths($i), // Agrego fecha de ingreso gradual por meses
                            'fecha_egreso' => Carbon::now()->subMonths($i - 1),
                        ])
                    );
                }
                $this->command->getOutput()->writeln('<info>  Creando departamentos para la ' . $division->nombre . '...</info>');
                $division->departamentos()->saveMany(factory(App\Departamento::class, 4)->make());
                $division->departamentos
                    ->each(function ($departamento)
                    use ($users, $num_jefes, $num_miembros) {
                        //Seleccionar 4 usuarios al azar
                        $jefes_rand = $users->random($num_jefes)->pluck('id')->toArray();
                        //Jefe activo
                        $departamento->jefes()->attach($jefes_rand[0]);
                        for ($i = $num_jefes-1; $i > 0; $i--) {
                            $departamento->jefes()->attach(
                                array($jefes_rand[$i] =>  [
                                    'actual' => false,
                                    'fecha_ingreso' => Carbon::now()->subMonths($i), // Agrego fecha de ingreso gradual por meses
                                    'fecha_egreso' => Carbon::now()->subMonths($i - 1),
                                ])
                            );
                        }
                        $this->command->getoutput()->writeln( '<info>    Creando academias para el Departamento de ' . $departamento->nombre . '...</info>');
                        $departamento->academias()->saveMany(factory(App\Academia::class, 10)->make()); // Creamos 10 academias nuevas
                        $departamento->academias->each(
                            function ($academia) use ($users, $num_jefes, $num_miembros) {
                                //Seleccionar 4 usuarios al azar para hacerlos presidentes de academia
                                $presidentes_rand = $users->random($num_jefes)->pluck('id')->toArray();
                                // --------- Presidente activo -----------
                                $academia->presidentes()->attach($presidentes_rand[0]);
                                for ($i = $num_jefes-1; $i > 0; $i--) {
                                    $academia->presidentes()->attach(
                                        array($presidentes_rand[$i] =>  [
                                            'actual' => false,
                                            'fecha_ingreso' => Carbon::now()->subMonths($i), // Agrego fecha de ingreso gradual por meses
                                            'fecha_egreso' => Carbon::now()->subMonths($i - 1),
                                        ])
                                    );
                                }
                                // ------------ Miembros de academia -------------
                                $miembros_rand = $users->random($num_miembros)->pluck('id')->toArray(); // Seleccionamos un número de usuarios al azar 
                                $academia->miembros()->attach($miembros_rand); // Y los hacemos miembros

                                // ------ Reuniones --------
                                $this->command->getoutput()->writeln('<info>      Creando reuniones para academia ' . $academia->nombre . '... </info>');
                                $academia->reuniones()->saveMany(factory(App\Reunion::class, 3)->make()); // Creamos 3 reuniones para cada academia
                                $academia->reuniones->each(function ($reunion) use ($users) {
                                    $reunion->temas()->saveMany(factory(App\Tema::class, 4)->make()); // Creamos 4 temas para cada reunión
                                    $reunion->convocados()->saveMany($reunion->academia->miembros); // Convocamos a todos los miembros a la reunion
                                    $reunion->invitadosExternos()->save($users->random()); // Convocamos a un usuario al azar como invitado externo
                                });
                            }
                        );
                    });
            });
    }
}
