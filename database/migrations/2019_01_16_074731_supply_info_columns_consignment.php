<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SupplyInfoColumnsConsignment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consignments', function (Blueprint $table) {
            $table->string('supply_no')->nullable()->after('final_city_id');
            $table->string('tracking_no')->nullable()->after('supply_no');
            $table->string('ticket_no')->nullable()->after('tracking_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consignments', function (Blueprint $table) {
            $table->dropColumn(['supply_no', 'tracking_no', 'ticket_no']);
        });
    }
}
