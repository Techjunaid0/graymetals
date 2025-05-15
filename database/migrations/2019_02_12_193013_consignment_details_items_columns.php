<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConsignmentDetailsItemsColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consignment_details', function (Blueprint $table) {
            $table->string('container_no')->nullable();
            $table->string('seal_no')->nullable();
            $table->float('tare_weight')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consignment_details', function (Blueprint $table) {
            $table->dropColumn(['container_no', 'seal_no', 'tare_weight']);
        });
    }
}
