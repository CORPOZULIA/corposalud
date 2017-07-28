<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general.modulos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            
            $table->string('nombre_modulo', 150);
            $table->text('descripcion_modulo');
            $table->string('url_modulo', 160);
            
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
        Schema::drop('general.modulos');
    }
}
