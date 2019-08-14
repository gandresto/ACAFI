<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademiaUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academia_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('academia_id');
            $table->unsignedBigInteger('user_id');
            $table->boolean('activo')->default(true);
            $table->date('fecha_ingreso');
            $table->date('fecha_egreso')->nullable();
            $table->timestamps();

            $table->index('academia_id');
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academia_user');
    }
}
