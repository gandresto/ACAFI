<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grados', function (Blueprint $table) {
            $table->string('id', 8)->unique();
            $table->string('descripcion', 45);
            $table->unsignedSmallInteger('jerarquia');

            $table->index('id');
            $table->primary('id');
        });

        DB::table('grados')->insert([
            [
                'id'=> 'Dr.', 
                'descripcion'=> 'Doctor',
                'jerarquia'=> 1
            ],
            [
                'id'=> 'Dra.', 
                'descripcion'=> 'Doctora',
                'jerarquia'=> 1
            ],
            [
                'id'=> 'M.A.', 
                'descripcion'=> 'Maestro en Administración',
                'jerarquia'=> 2
            ],
            [
                'id'=> 'M.C.', 
                'descripcion'=> 'Maestro en Ciencias',
                'jerarquia'=> 2
            ],
            [
                'id'=> 'M.E.', 
                'descripcion'=> 'Maestro en Educación',
                'jerarquia'=> 2
            ],
            [
                'id'=> 'M.E.M.', 
                'descripcion'=> 'Maestro en Educación Matemática',
                'jerarquia'=> 2
            ],
            [
                'id'=> 'M.E.S.', 
                'descripcion'=> 'Maestro en Educación Superior',
                'jerarquia'=> 2
            ],
            [
                'id'=> 'M.en.Arq', 
                'descripcion'=> 'Maestro en Arquitectura',
                'jerarquia'=> 2
            ],
            [
                'id'=> 'M.F.', 
                'descripcion'=> 'Maestro en Filosofía',
                'jerarquia'=> 2
            ],
            [
                'id'=> 'M.I.', 
                'descripcion'=> 'Maestro en Ingeniería',
                'jerarquia'=> 2
            ],
            [
                'id'=> 'Mtra.', 
                'descripcion'=> 'Maestra',
                'jerarquia'=> 2
            ],
            [
                'id'=> 'Mtro.', 
                'descripcion'=> 'Maestro',
                'jerarquia'=> 2
            ],
            [
                'id'=> 'Arq.', 
                'descripcion'=> 'Arquitecto',
                'jerarquia'=> 3
            ],
            [
                'id'=> 'Biól.', 
                'descripcion'=> 'Biólogo',
                'jerarquia'=> 3
            ],
            [
                'id'=> 'C.F.', 
                'descripcion'=> 'Contador Fiscal',
                'jerarquia'=> 3
            ],
            [
                'id'=> 'C.P.', 
                'descripcion'=> 'Contador Público',
                'jerarquia'=> 3
            ],
            [
                'id'=> 'Fís.', 
                'descripcion'=> 'Físico',
                'jerarquia'=> 3
            ],
            [
                'id'=> 'I.Q.', 
                'descripcion'=> 'Ing. Químico',
                'jerarquia'=> 3
            ],
            [
                'id'=> 'Ing.', 
                'descripcion'=> 'Ingeniero',
                'jerarquia'=> 3
            ],
            [
                'id'=> 'L.C.', 
                'descripcion'=> 'Licenciado en Contaduría',
                'jerarquia'=> 3
            ],
            [
                'id'=> 'LDG.', 
                'descripcion'=> 'Licenciatura en Diseño Gráfico',
                'jerarquia'=> 3
            ],
            [
                'id'=> 'Lic.', 
                'descripcion'=> 'Licenciado',
                'jerarquia'=> 3
            ],
            [
                'id'=> 'Quím.', 
                'descripcion'=> 'Químico',
                'jerarquia'=> 3
            ],
            [
                'id'=> 'Sr.', 
                'descripcion'=> 'Señor',
                'jerarquia'=> 4
            ],
            [
                'id'=> 'Srita.', 
                'descripcion'=> 'Señorita',
                'jerarquia'=> 4
            ],
            [
                'id'=> 'C.', 
                'descripcion'=> 'Ciudadano',
                'jerarquia'=> 4
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grados');
    }
}
