<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DoorOrientationColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instructions', function (Blueprint $table) {
            $table->enum('door_orientation', ['Towards Rear', ['Towards Cab']]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('instructions', function (Blueprint $table) {
            $table->dropColumn(['door_orientation']);
        });
    }
}
