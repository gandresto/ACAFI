<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcuerdosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acuerdos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descripcion', 240);
            $table->string('resultado', 240)->nullable();
            $table->string('producto_esperado', 240);
            $table->timestamp('fecha_compromiso')->useCurrent();
            $table->timestamp('fecha_finalizado')->nullable();
            $table->timestamps();

            // Campos para relaciones por llave foránea
            $table->unsignedBigInteger('tema_id');
            $table->unsignedBigInteger('responsable_id');
            
            // Índices
            $table->index('responsable_id');
            $table->index('fecha_finalizado');
            $table->index('fecha_compromiso');
            $table->index('tema_id');
            
            // Constraints de foreign key
            $table->foreign('responsable_id')->references('id')->on('users');
            $table->foreign('tema_id')
                    ->references('id')
                    ->on('temas')
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
        Schema::dropIfExists('acuerdos');
    }
}
