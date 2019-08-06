<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademiaAcademicoPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academia_academico', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('academia_id');
            $table->unsignedBigInteger('academico_id');
            $table->boolean('activo')->default(true);
            $table->date('fecha_ingreso');
            $table->date('fecha_egreso')->nullable();
            $table->timestamps();

            $table->index('academia_id');
            $table->index('academico_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academia_academico');
    }
}
