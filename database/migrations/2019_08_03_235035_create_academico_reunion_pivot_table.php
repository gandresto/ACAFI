<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicoReunionPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academico_reunion', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('academico_id');
            $table->unsignedBigInteger('reunion_id');
            $table->boolean('asistio')->default(false);

            $table->index('academico_id');
            $table->index('reunion_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academico_reunion');
    }
}
