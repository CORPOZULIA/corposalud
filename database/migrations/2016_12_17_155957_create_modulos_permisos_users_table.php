<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulosPermisosUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general.modulos_permisos_users', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('user_id')->unsigned();
            $table->integer('permiso_id')->unsigned();
            $table->integer('modulo_id')->unsigned();
            
            $table->tinyInteger('edo_reg')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('general.modulos_permisos_users');
    }
}
