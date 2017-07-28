<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBeneficiarioNominasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corposalud.beneficiario_nominas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->integer('beneficiario_id')->unsigned();
            $table->integer('nomina_id')->unsigned();

            $table->foreign('beneficiario_id')->references('id')
                    ->on('corposalud.beneficiarios')->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->foreign('nomina_id')->references('id')
                    ->on('corposalud.nominas')->onDelete('CASCADE')->onUpdate('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('corposalud.beneficiario_nominas');
    }
}
