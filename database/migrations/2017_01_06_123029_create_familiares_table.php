<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamiliaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corposalud.familiares', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('nombres',150);
            $table->string('apellidos',150);
            $table->date('fecha_nacimiento');
            $table->string('cedula',12);
            $table->integer('beneficiario_id')->unsigned();
            $table->tinyInteger('edo_reg')->default(1);

            $table->foreign('beneficiario_id')->references('id')
                  ->on('corposalud.beneficiarios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('corposalud.familiares');
    }
}
