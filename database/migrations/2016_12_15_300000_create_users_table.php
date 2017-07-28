<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general.users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('usuario');
            $table->string('password');
            $table->string('remember_token', 255)->nullable();
            $table->tinyInteger('edo_reg')->default(1);
            $table->integer('empleado_id')->unsigned();
            
            $table->timestamps();

            $table->foreign('empleado_id')
                    ->references('id')
                    ->on('general.empleados')
                    ->onDelate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('general.users');
    }
}
