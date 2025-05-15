<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CourierAndInvoiceColumnsConsignment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('consignments', function (Blueprint $table) {
            $table->boolean('document_sent')->default(false)->after('price');
            $table->enum('courier_service', ['dhl', 'ups'])->nullable()->after('document_sent');
            $table->string('courier_tracking_no')->nullable()->after('courier_service');
            $table->date('courier_last_tracked')->nullable()->after('courier_tracking_no');
            $table->string('courier_status')->nullable()->after('courier_last_tracked');
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
            $table->dropColumn(['document_sent', 'courier_service', 'courier_tracking_no', 'courier_last_tracked', 'courier_status']);
        });
    }
}
