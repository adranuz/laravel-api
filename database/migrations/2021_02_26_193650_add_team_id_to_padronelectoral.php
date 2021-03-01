<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTeamIdToPadronelectoral extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('padronelectoral', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable()->foreign('team_id')->references('id')->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('padronelectoral', function (Blueprint $table) {
            $table->dropColumn('team_id');
        });
    }
}
