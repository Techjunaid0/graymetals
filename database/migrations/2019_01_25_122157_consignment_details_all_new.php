<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConsignmentDetailsAllNew extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('consignment_details');

        Schema::create('consignment_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('consignment_id');
            $table->foreign('consignment_id')->references('id')->on('consignments');
            $table->string('description');
            $table->double('item_weight');
            $table->double('price');
            $table->double('total_price');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consignment_details');
        
        require_once database_path('migrations/2018_12_19_051353_create_consignment_details_table.php');
        $obj = new CreateConsignmentDetailsTable();
        $obj->up();
    }
}
