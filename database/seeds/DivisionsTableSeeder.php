<?php

use Illuminate\Database\Seeder;

class DivisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Division::class, 5)->create()->each(function ($division) {
            $division->departamentos()
                        ->saveMany(factory(App\Departamento::class, 4)->make());
        });
    }
}
