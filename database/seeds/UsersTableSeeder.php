<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create($locale = 'es_ES');
        $password = bcrypt('123456789'); // password fija para no calcularla cada vez
        
        for ($i = 0; $i < 300; $i++) {
            $user = App\User::create([
                'grado' => $faker->randomElement(array('Ing.', 'Dr.', 'M.I.')),
                'nombre' => $faker->firstName,
                'apellido_pat' => $faker->lastName,
                'apellido_mat' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'password' => $password,
                'remember_token' => Str::random(10),
            ]);
            $user->rollApiKey();
        }
    }
}
