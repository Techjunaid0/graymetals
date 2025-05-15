<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ShippingCoRelatedColumnsConsignment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consignments', function (Blueprint $table) {
            $table->dropColumn(['supply_no', 'tracking_no', 'ticket_no']);
            $table->date('confirmation_date')->after('final_city_id')->nullable();
            $table->string('carrier')->after('confirmation_date')->nullable();
            $table->string('reference')->after('carrier')->nullable();
            $table->string('line_reference')->after('reference')->nullable();
            $table->string('vessel')->after('line_reference')->nullable();
            $table->string('ucr')->after('vessel')->nullable();
            $table->date('ets')->after('ucr')->nullable();
            $table->date('eta')->after('ets')->nullable();
            $table->date('tracking_url')->after('eta')->nullable();
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
            $table->dropColumn(['confirmation_date', 'carrier', 'reference', 'line_reference', 'vessel', 'ucr', 'ets', 'eta']);
            $table->string('supply_no')->after('final_city_id')->nullable();
            $table->string('tracking_no')->after('supply_no')->nullable();
            $table->string('ticket_no')->after('tracking_no')->nullable();
        });
    }
}
