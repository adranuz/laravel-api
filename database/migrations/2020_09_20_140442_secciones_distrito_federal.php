<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeccionesDistritoFederal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secciones_distrito_federal', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('clave_entidad_federal')->foreign('clave_entidad_federal')->references('id')->on('entidades_federales');
            $table->unsignedBigInteger('seccion')->foreign('seccion')->references('secciones')->on('seccion');
            $table->integer('distrito_federal');
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
        Schema::dropIfExists('secciones_distrito_federal');
    }
}
