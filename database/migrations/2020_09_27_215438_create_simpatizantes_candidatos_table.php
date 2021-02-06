<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSimpatizantesCandidatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simpatizantes_candidatos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('padronelectoral_id')->unsigned()->foreign('padronelectoral_id')->references('id')->on('padronelectoral');
            $table->unsignedBigInteger('candidato_id')->foreign('candidato_id')->references('id')->on('candidato');
            $table->integer('seccion_id')->unsigned()->nullable();
            $table->string('simpatiza', 50);
            $table->json('data')->nullable();
            $table->integer('created_by')->unsigned()->nullable();
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
        Schema::dropIfExists('simpatizantes_candidatos');
    }
}
