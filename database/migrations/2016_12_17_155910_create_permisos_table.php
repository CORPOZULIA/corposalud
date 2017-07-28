<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general.permisos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('nombre_permiso');
            $table->text('descripcion_permiso');
            
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
        Schema::drop('general.permisos');
    }
}
