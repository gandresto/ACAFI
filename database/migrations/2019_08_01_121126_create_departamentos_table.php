<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepartamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departamentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nombre', 50)->unique();
            $table->boolean('activo')->default(True);
            //$table->unsignedBigInteger('jefe_dpto_id');
            $table->unsignedBigInteger('division_id');
            $table->timestamps();

            //$table->index('jefe_dpto_id');
            $table->index('division_id');
            $table->foreign('division_id')->references('id')->on('divisions');
            $table->index('nombre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departamentos');
    }
}
