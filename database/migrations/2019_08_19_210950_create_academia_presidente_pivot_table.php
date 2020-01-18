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
            $table->boolean('actual')->default(true);
            $table->date('fecha_ingreso')->default(Carbon::now());
            $table->date('fecha_egreso')->nullable();

            $table->index('actual');

            $table->index('academia_id');
            $table->foreign('academia_id')->references('id')->on('academias');
            $table->index('presidente_id');
            $table->foreign('presidente_id')->references('id')->on('users');
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
