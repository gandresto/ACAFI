<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcuerdosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acuerdos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descripcion', 240);
            $table->boolean('resuelto')->default(0);
            $table->string('resultado', 240)->nullable();
            $table->string('producto_esperado', 240);
            $table->date('fecha_compromiso');
            $table->date('fecha_resuelto')->nullable();
            $table->unsignedBigInteger('tema_id');
            $table->timestamps();

            $table->index('resuelto');
            $table->index('fecha_compromiso');

            $table->index('tema_id');
            $table->foreign('tema_id')->references('id')->on('temas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acuerdos');
    }
}
