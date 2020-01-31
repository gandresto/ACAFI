<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;

class CreateDepartamentoJefePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departamento_jefe', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('departamento_id');
            $table->unsignedBigInteger('jefe_id');
            $table->timestamp('fecha_ingreso')->useCurrent();
            $table->timestamp('fecha_egreso')->nullable();

            $table->index('fecha_egreso');
            $table->index('departamento_id');
            $table->index('jefe_id');

            $table->foreign('departamento_id')
                    ->references('id')
                    ->on('departamentos')
                    ->onDelete('cascade');

            $table->foreign('jefe_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('departamento_jefe');
    }
}
