<?php

use App\Academia;
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
        // ------------------- Creando usuarios -------------------
        
        $this->crearUsuarios(300);

        // ----------- Creamos divisiones, departamentos y academias. ---------------
        $this->crearEstructuraFI();
    }
    public function crearUsuarios($num_usuarios=200)
    {   
        $faker = \Faker\Factory::create($locale = 'es_ES');
        $password = bcrypt('123456789'); // password
        echo 'Creando usuarios\n';
        for ($i = 0; $i < $num_usuarios; $i++) {
            App\User::create([
                'grado' => $faker->randomElement(array('Ing.', 'Dr.', 'M.I.')),
                'nombre' => $faker->firstName,
                'apellido_pat' => $faker->lastName,
                'apellido_mat' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => $password, // password
                'api_token' => Str::random(80),
                'remember_token' => Str::random(10),
            ]);
        }
    }

    public function crearEstructuraFI($num_jefes = 4, $num_miembros = 7, $num_reuniones = 3)
    {
        // Carbon::now() = Carbon::now();
        $users = App\User::all();
        echo ' Creando divisiones... ';
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
                echo ' Creando departamentos para la ' . $division->nombre . '... ';
                $division->departamentos()->saveMany(factory(App\Departamento::class, 4)->make());
                $division->departamentos
                    ->each(function ($departamento)
                    use ($users, $num_jefes, $num_miembros) {
                        //echo 'Creando academias para Dpto. '.$departamento->nombre .'\n';
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
                        echo 'Creando academias para el Departamento de ' . $departamento->nombre . '... ';
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
                                echo 'Creando reuniones para academia ' . $academia->nombre . '... ';
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
