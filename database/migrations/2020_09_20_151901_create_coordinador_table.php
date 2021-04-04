<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoordinadorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('coordinador', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('configuracion');
            $table->unsignedBigInteger('candidato_id')->foreign('candidato_id')->references('id')->on('candidato');            
            $table->timestamps();
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coordinador');
    }
}
