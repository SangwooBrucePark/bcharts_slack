<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('teams', function ($table) {
            $table->string('team_id', 50);
            $table->string('team_name', 100);
            $table->string('access_token', 100);
            $table->string('scope', 255);
            $table->string('bot_user_id', 50);
            $table->string('bot_access_token', 100);
            $table->string('user_id', 50);
            $table->timestamps();
            $table->primary('team_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('teams');
    }
}
