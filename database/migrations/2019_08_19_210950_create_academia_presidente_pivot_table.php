<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Carbon;

class CreateAcademiaPresidentePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academia_presidente', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('academia_id');
            $table->unsignedBigInteger('presidente_id');
            $table->timestamp('fecha_ingreso')->useCurrent();
            $table->timestamp('fecha_egreso')->nullable();

            $table->index('fecha_egreso');
            $table->index('academia_id');
            $table->index('presidente_id');

            $table->foreign('academia_id')
                    ->references('id')
                    ->on('academias')
                    ->onDelete('cascade');

            $table->foreign('presidente_id')
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
        Schema::dropIfExists('academia_presidente');
    }
}
