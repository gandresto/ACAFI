<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Carbon\Carbon;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('grado', 8);
            $table->string('nombre');
            $table->string('apellido_pat');
            $table->string('apellido_mat');
            $table->string('email', 50)->unique();
            $table->string('password');
            $table->string('api_token', 80)->unique()
                        ->nullable()
                        ->default(null);
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(
            array(
                'id' => 1,
                'email' => config('admin.email'),
                'password' => bcrypt(config('admin.password')),
                'grado'=> config('admin.grado'),
                'nombre'=> config('admin.nombre'),
                'apellido_pat'=> config('admin.apellido_pat'),
                'apellido_mat'=> config('admin.apellido_mat'),
                'remember_token' => Str::random(10),
                'api_token' => Str::random(80),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
