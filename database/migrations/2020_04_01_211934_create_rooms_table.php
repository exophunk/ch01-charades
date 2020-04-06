<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->smallInteger('round_duration')->default(60);
            $table->smallInteger('cycle')->default(0);
            $table->foreignId('admin_user_id')->nullable();
            $table->timestamps();

            $table->foreign('admin_user_id')->references('id')->on('users')
                ->onDelete('set null')
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
        Schema::table('rooms', function(Blueprint $table) {
            $table->dropForeign('rooms_admin_user_id_foreign');
		});
        Schema::dropIfExists('rooms');
    }
}
