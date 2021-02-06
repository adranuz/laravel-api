<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EntidadesFederativas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entidades_federales', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->integer('distritos');
            $table->integer('municipios');

            $table->integer('secciones_urbanas');
            $table->integer('secciones_rurales');
            $table->integer('secciones_mixtas');
            $table->integer('total_secciones');

            $table->integer('localidades_urbanas');
            $table->integer('localidades_rurales');
            $table->integer('total_localidades');
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
        Schema::dropIfExists('entidades_federales');
    }
}
