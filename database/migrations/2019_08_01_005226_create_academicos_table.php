<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academicos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('grado_id', 8);
            $table->string('nombre');
            $table->string('apellido_pat');
            $table->string('apellido_mat');
            $table->timestamps();

            $table->index('grado_id');
        });

        App\Academico::create([
            'id' => 1,
            'grado_id'=> config('admin.grado'),
            'nombre'=> config('admin.nombre'),
            'apellido_pat'=> config('admin.apellido_pat'),
            'apellido_mat'=> config('admin.apellido_mat'),
        ]);

/*         DB::table('academicos')->insert([
            [
                'id' => 1,
                'grado_id'=> config('admin.grado'),
                'nombre'=> config('admin.nombre'),
                'apellido_pat'=> config('admin.apellido_pat'),
                'apellido_mat'=> config('admin.apellido_mat'),
            ],
        ]); */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academicos');
    }
}
