<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeccionesDistritoLocal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secciones_distrito_locales', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('clave_entidad_federal')->foreign('clave_entidad_federal')->references('id')->on('entidades_federales');
            $table->unsignedBigInteger('clave_municipio')->foreign('clave_municipio')->references('clave_municipio')->on('municipios');
            $table->unsignedBigInteger('seccion')->foreign('seccion')->references('secciones')->on('seccion');
            $table->unsignedBigInteger('distrito_federal')->foreign('distrito_federal')->references('distrito_federal')->on('secciones_distrito_federal');
            $table->integer('distrito_local');
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
        Schema::dropIfExists('secciones_distrito_locales');
    }
}
