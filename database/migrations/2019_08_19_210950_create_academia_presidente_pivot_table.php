<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->boolean('actual')->default(true);
            $table->date('fecha_ingreso');
            $table->date('fecha_egreso')->nullable();

            $table->index('academia_id');
            $table->index('presidente_id');
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
        Schema::dropIfExists('academia_presidente');
    }
}
