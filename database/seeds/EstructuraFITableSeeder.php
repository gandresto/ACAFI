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
        $faker = \Faker\Factory::create();
        $password = bcrypt('123456'); // password
        for ($i=0; $i < 50; $i++) { 
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
