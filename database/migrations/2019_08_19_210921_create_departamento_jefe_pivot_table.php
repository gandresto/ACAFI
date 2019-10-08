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
            $table->boolean('actual')->default(true);
            $table->date('fecha_ingreso')->default(Carbon::now());
            $table->date('fecha_egreso')->nullable();

            $table->index('departamento_id');
            $table->index('jefe_id');
            $table->index('actual');
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