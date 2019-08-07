<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
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
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('academico_id')->unique();
            $table->rememberToken();
            $table->timestamps();

            $table->index('academico_id');
        });

        #DB::update("ALTER TABLE users AUTO_INCREMENT = 2;");

        DB::table('users')->insert([
            [
                'id' => 1,
                'email'=> config('admin.login'),
                'password'=> Hash::make(config('admin.password')),
                'academico_id' => 1,
                'created_at' => Carbon::now()->format('Y-m-d H:m:s'),
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
        Schema::dropIfExists('users');
    }
}
