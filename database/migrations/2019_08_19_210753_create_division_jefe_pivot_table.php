<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;

class CreateDivisionJefePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('division_jefe', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('division_id');
            $table->unsignedBigInteger('jefe_id');
            $table->boolean('actual')->default(true);
            $table->date('fecha_ingreso')->default(Carbon::now());
            $table->date('fecha_egreso')->nullable();

            $table->index('actual');

            $table->index('division_id');
            $table->foreign('division_id')->references('id')->on('divisions');
            $table->index('jefe_id');
            $table->foreign('jefe_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('division_jefe');
    }
}
