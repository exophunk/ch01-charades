<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rounds', function (Blueprint $table) {
            $table->id();
            $table->timestamp('round_start')->nullable();
            $table->timestamp('round_end')->nullable();
            $table->smallInteger('cycle');
            $table->smallInteger('score')->default(0);
            $table->foreignId('team_id');
            $table->foreignId('user_id');
            $table->foreignId('room_id');
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_id')->references('id')->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('room_id')->references('id')->on('rooms')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rounds', function(Blueprint $table) {
            $table->dropForeign('rounds_team_id_foreign');
            $table->dropForeign('rounds_user_id_foreign');
            $table->dropForeign('rounds_room_id_foreign');
		});
        Schema::dropIfExists('rounds');
    }
}
