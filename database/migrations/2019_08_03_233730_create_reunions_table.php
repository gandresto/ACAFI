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
            $table->bigIncrements('id');
            $table->string('lugar');
            $table->timestamp('inicio')->nullable();
            $table->timestamp('fin')->nullable();
            $table->string('orden_del_dia')->nullable();
            $table->string('minuta')->nullable();
            $table->boolean('cancelada')->default(false);
            $table->timestamps();
            
            // Campos para llaves foráneas
            $table->unsignedBigInteger('academia_id');

            //Índices 
            $table->index('cancelada');
            $table->index('academia_id');

            // Constraints de foreign key
            $table->foreign('academia_id')
                    ->references('id')
                    ->on('academias')
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
        Schema::dropIfExists('reunions');
    }
}
