<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeneficiarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corposalud.beneficiarios', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('persona_id')->unsigned();
            $table->integer('disponibilidad_id')->unsigned();
            $table->tinyInteger('edo_reg')->default(1);
            $table->foreign('persona_id')->references('id')
                    ->on('general.personas')->onDelete('CASCADE');

            $table->foreign('disponibilidad_id')->references('id')
                    ->on('corposalud.disponibilidades')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('corposalud.beneficiaiarios');
    }
}
