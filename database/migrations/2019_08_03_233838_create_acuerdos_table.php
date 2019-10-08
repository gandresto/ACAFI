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
            $table->increments('id');
            $table->string('descripcion', 240);
            $table->boolean('resuelto')->default(0);
            $table->string('resultado', 240)->nullable();
            $table->string('producto_esperado', 240);
            $table->unsignedBigInteger('tema_id');
            $table->timestamps();
            
            $table->index('tema_id');
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
