<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('messages', function ($table) {
            $table->string('ts', 50);
            $table->string('channel', 50);
            $table->string('user_id', 50);
            $table->text('message');
            $table->integer('update_cycle')->unsigned();
            $table->timestamp('chart_updated_at')->nullable();
            $table->timestamps();
            $table->primary('ts');
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
        Schema::dropIfExists('messages');
    }
}
