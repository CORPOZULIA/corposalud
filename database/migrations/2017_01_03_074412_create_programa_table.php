<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general.programas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('nombre_programa', 150);
            $table->text('descripcion_programa');
            $table->string('url_programa', 160);
            $table->integer('modulo_id')->unsigned();
            
            $table->foreign('modulo_id')->on('general.modulos')
                    ->references('id')->onDelete('cascade');
            
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
        Schema::drop('general.programas');
    }
}
