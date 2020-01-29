<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCampoResponsable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('acuerdos', function (Blueprint $table) {
            $table->unsignedBigInteger('responsable_id');
            $table->index('responsable_id');
            $table->foreign('responsable_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('acuerdos', function (Blueprint $table) {
            $table->dropIndex(['responsable_id']);
            $table->dropForeign(['responsable_id']);
            $table->dropColumn('responsable_id');
        });
    }
}
