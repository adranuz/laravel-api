<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 300);
            $table->integer('desired_quantity');
            $table->string('accomplished', 300);
            $table->unsignedBigInteger('created_by')->foreign('created_by')->references('id')->on('users');;
            $table->unsignedBigInteger('type_sympathizer_id')->foreign('type_symphatizer_id')->references('id')->on('type_sympathizer');
            $table->unsignedBigInteger('demarcaciones_id')->foreign('demarcaciones_id')->references('id')->on('demarcaciones');
            $table->unsignedBigInteger('municipios_id')->foreign('municipios_id')->references('id')->on('municipios');            
            $table->unsignedBigInteger('seccion_id')->nullable()->foreign('seccion_id')->references('id')->on('secciones');
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
        Schema::dropIfExists('goals');
    }
}
