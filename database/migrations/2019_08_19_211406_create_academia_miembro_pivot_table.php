<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademiaMiembroPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academia_miembro', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('academia_id');
            $table->unsignedBigInteger('miembro_id');
            $table->boolean('activo')->default(true);
            $table->date('fecha_ingreso')->default(Carbon::now());;
            $table->date('fecha_egreso')->nullable();

            $table->index('academia_id');
            $table->index('miembro_id');
            $table->index('activo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('academia_miembro');
    }
}
