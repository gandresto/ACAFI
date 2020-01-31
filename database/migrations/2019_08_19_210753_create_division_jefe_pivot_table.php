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
            $table->timestamp('fecha_ingreso')->useCurrent();
            $table->timestamp('fecha_egreso')->nullable();

            $table->index('fecha_egreso');
            $table->index('division_id');
            $table->index('jefe_id');

            $table->foreign('division_id')
                    ->references('id')
                    ->on('divisions')
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
        Schema::dropIfExists('division_jefe');
    }
}
