<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        #$this->call(DivisionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(EstructuraFITableSeeder::class);
        // Log::info('Información a consola.');
    }
}
