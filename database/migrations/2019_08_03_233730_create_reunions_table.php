<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReunionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reunions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('academia_id');
            $table->string('lugar');
            $table->dateTime('inicio');
            $table->dateTime('fin');
            $table->string('orden_del_dia')->nullable();
            $table->string('minuta')->nullable();
            $table->timestamps();

            $table->index('academia_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reunions');
    }
}
