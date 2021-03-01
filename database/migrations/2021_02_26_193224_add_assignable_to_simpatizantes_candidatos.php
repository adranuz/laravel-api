<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAssignableToSimpatizantesCandidatos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('simpatizantes_candidatos', function (Blueprint $table) {
            //$table->morphs('assign')->nullable();
            $table->string('assign_type')->nullable();
            $table->string('assign_id')->nullable();
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
            $table->dropColumn('assign_type');
            $table->dropColumn('assign_id');
        });
    }
}
