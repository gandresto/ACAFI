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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('academia_id');
            $table->unsignedBigInteger('miembro_id');
            $table->timestamp('fecha_ingreso')->useCurrent();
            $table->timestamp('fecha_egreso')->nullable();
            $table->index('fecha_egreso');

            $table->index('academia_id');
            $table->index('miembro_id');

            $table->foreign('academia_id')
                    ->references('id')
                    ->on('academias')
                    ->onDelete('cascade');

            $table->foreign('miembro_id')
                    ->references('id')
                    ->on('users')
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
        Schema::dropIfExists('academia_miembro');
    }
}
