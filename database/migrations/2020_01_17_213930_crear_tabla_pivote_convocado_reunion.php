<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaPivoteConvocadoReunion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('convocado_reunion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('convocado_id');
            $table->unsignedBigInteger('reunion_id');
            $table->boolean('asistio')->default(false);

            $table->index('convocado_id');
            $table->foreign('convocado_id')->references('id')->on('users');
            $table->index('reunion_id');
            $table->foreign('reunion_id')->references('id')->on('reunions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('convocado_reunion');
    }
}
