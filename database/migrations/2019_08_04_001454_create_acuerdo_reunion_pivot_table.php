<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcuerdoReunionPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acuerdo_reunion', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('acuerdo_id');
            $table->unsignedBigInteger('reunion_id');
            $table->string('avance')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('acuerdo_reunion');
    }
}
