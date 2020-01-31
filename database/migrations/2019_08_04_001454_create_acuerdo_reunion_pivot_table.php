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
            $table->bigIncrements('id');
            $table->string('avance')->nullable();
            $table->unsignedBigInteger('acuerdo_id');
            $table->unsignedBigInteger('reunion_id');

            $table->index('acuerdo_id');
            $table->index('reunion_id');

            $table->foreign('acuerdo_id')
                    ->references('id')
                    ->on('acuerdos')
                    ->onDelete('cascade');

            $table->foreign('reunion_id')
                    ->references('id')
                    ->on('reunions')
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
        Schema::dropIfExists('acuerdo_reunion');
    }
}
