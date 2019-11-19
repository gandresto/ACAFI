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
        $faker = \Faker\Factory::create($locale='es_ES');
        $password = bcrypt('123456789'); // password
        echo 'Creando usuarios\n';
        for ($i=0; $i < 200; $i++) {
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
        //factory(App\User::class, 50)->create();

        // Creamos divisiones, departamentos y academias.
        $users=App\User::all();
        $num_jefes = 4;
        $num_miembros = 7;
        echo ' Creando divisiones... ';
        factory(App\Division::class, 5)->create()->each(function ($division) use ($users, $num_jefes){
            //Seleccionar 4 usuarios al azar para hacerlos jefes de division
            $jefes_rand = $users->random($num_jefes)->pluck('id')->toArray();
            //Jefe Activo
            $division->jefes()->attach($jefes_rand[0]);
            //Jefes inactivos
            for ($i=0; $i < $num_jefes; $i++) {
                $division->jefes()->attach(
                    array($jefes_rand[$i] => ['actual' => false])
                );
            }
            echo ' Creando departamentos para la '.$division->nombre.'... ';
            $division->departamentos()->saveMany(factory(App\Departamento::class, 4)->make());
            $division->departamentos->each(function ($departamento) use ($users, $num_jefes, $num_miembros )
                {
                    //echo 'Creando academias para Dpto. '.$departamento->nombre .'\n';
                    //Seleccionar 4 usuarios al azar
                    $jefes_rand = $users->random($num_jefes)->pluck('id')->toArray();
                    //Jefe activo
                    $departamento->jefes()->attach($jefes_rand);
                    for ($i=0; $i < $num_jefes; $i++) {
                        $departamento->jefes()->attach(
                            array($jefes_rand[$i] => ['actual' => false])
                        );
                    }
                    echo 'Creando academias para el Departamento de '.$departamento->nombre .'... ';
                    $departamento->academias()->saveMany(factory(App\Academia::class, 10)->make());
                    $departamento->academias->each(function ($academia) use ($users, $num_jefes, $num_miembros)
                        {
                            //Seleccionar 4 usuarios al azar para hacerlos presidentes de academia
                            $presidentes_rand = $users->random($num_jefes)->pluck('id')->toArray();
                            //Jefe activo
                            $academia->presidentes()->attach($presidentes_rand);
                            for ($i=0; $i < $num_jefes; $i++) {
                                $academia->presidentes()->attach(
                                    array($presidentes_rand[$i] => ['actual' => false])
                                );
                            }
                            $miembros_rand = $users->random($num_miembros)->pluck('id')->toArray();
                            $academia->miembros()->attach($miembros_rand);
                        }
                    );
                });
        });
    }
}
