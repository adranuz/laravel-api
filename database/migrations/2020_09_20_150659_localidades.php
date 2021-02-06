<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Localidades extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localidades', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('clave_entidad_federal')->foreign('clave_entidad_federal')->references('id')->on('entidades_federales');
            $table->unsignedBigInteger('clave_municipio')->foreign('clave_municipio')->references('clave_municipio')->on('municipios');
            $table->integer('localidad');
            $table->string('nombre');
            $table->string('tipo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('localidades');
    }
}
