<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTemasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descripcion');
            $table->text('comentario')->nullable();
            $table->unsignedBigInteger('reunion_id');
            $table->timestamps();

            $table->index('reunion_id');
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
        Schema::dropIfExists('temas');
    }
}
