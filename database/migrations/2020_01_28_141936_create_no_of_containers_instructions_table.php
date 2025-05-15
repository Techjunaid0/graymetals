<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNoOfContainersInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('instructions', function (Blueprint $table) {
            $table->string('no_of_containers')->nullable()->after('pickup_datetime');

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
            $table->dropColumn('no_of_containers');
        });
    }
}
