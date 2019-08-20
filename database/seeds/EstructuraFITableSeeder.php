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
            $division->jefes()->attach(
                $users->random(rand(2, 51))->pluck('id')->toArray()
            );
            //$division->jefes()->sync(
            //    $users->random(rand(2, 51))->pluck('id')->toArray()
            //);
            //$division->jefes()->saveMany($users);
        });
    }
}
