<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaPivoteInvitadoReunion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitado_reunion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invitado_id');
            $table->unsignedBigInteger('reunion_id');
            $table->boolean('asistio')->default(false);

            $table->index('invitado_id');
            $table->foreign('invitado_id')->references('id')->on('users');
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
        Schema::dropIfExists('invitado_reunion');
    }
}
