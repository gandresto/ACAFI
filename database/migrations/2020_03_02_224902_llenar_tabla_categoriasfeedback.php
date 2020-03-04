<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LlenarTablaCategoriasfeedback extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('categoriasfeedback')->insert([
            [
                'id' => 1,
                'descripcion'=> 'Comentarios/Sugerencias',
            ],
            [
                'id' => 2,
                'descripcion'=> 'Reporte de error',
            ],
            [
                'id' => 3,
                'descripcion'=> 'Dudas/Aclaraciones',
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('categoriasfeedback')->delete([1,2,3]);
    }
}
