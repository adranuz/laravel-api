<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnDemarcacionIdToSimpatizantes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('simpatizantes_candidatos', function (Blueprint $table) {
            $table->unsignedBigInteger('demarcacion_id')->default(1)->foreign('demarcacion_id')->references('id')->on('demarcaciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('simpatizantes_candidatos', function (Blueprint $table) {
            $table->dropColumn('demarcacion_id');
        });
    }
}
