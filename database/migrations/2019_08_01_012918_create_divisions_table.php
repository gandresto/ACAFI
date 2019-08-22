<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDivisionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('divisions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('siglas', 10)->unique();
            $table->string('nombre', 50)->unique();
            $table->string('url', 200);
            $table->string('logo', 200)->nullable();
            $table->boolean('activa')->default(True);
            #$table->unsignedBigInteger('jefe_div_id');
            $table->timestamps();

            $table->index('nombre');
            $table->index('siglas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('divisions');
    }
}
