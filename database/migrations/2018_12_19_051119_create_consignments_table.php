<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consignments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('instruction_id');
            // $table->foreign('instruction_id')->references('id')->on('instructions');
            $table->unsignedInteger('shipper_id')->nullable();
            $table->foreign('shipper_id')->references('id')->on('shippers');
            $table->unsignedInteger('consignee_id')->nullable();
            $table->foreign('consignee_id')->references('id')->on('consignees');
            $table->unsignedInteger('notify_party_id')->nullable();
            // $table->foreign('notify_party_id')->references('id')->on('notify_parties');
            $table->unsignedInteger('loading_port_id')->nullable();
            $table->foreign('loading_port_id')->references('id')->on('ports');
            $table->unsignedInteger('loading_country_id')->nullable();
            $table->foreign('loading_country_id')->references('id')->on('countries');
            $table->unsignedInteger('loading_state_id')->nullable();
            $table->foreign('loading_state_id')->references('id')->on('states');
            $table->unsignedInteger('loading_city_id')->nullable();
            $table->foreign('loading_city_id')->references('id')->on('cities');
            $table->unsignedInteger('discharge_port_id')->nullable();
            $table->foreign('discharge_port_id')->references('id')->on('ports');
            $table->unsignedInteger('discharge_country_id')->nullable();
            $table->foreign('discharge_country_id')->references('id')->on('countries');
            $table->unsignedInteger('discharge_state_id')->nullable();
            $table->foreign('discharge_state_id')->references('id')->on('states');
            $table->unsignedInteger('discharge_city_id')->nullable();
            $table->foreign('discharge_city_id')->references('id')->on('cities');
            $table->string('final_destination');
            $table->unsignedInteger('final_country_id')->nullable();
            $table->foreign('final_country_id')->references('id')->on('countries');
            $table->unsignedInteger('final_state_id')->nullable();
            $table->foreign('final_state_id')->references('id')->on('states');
            $table->unsignedInteger('final_city_id')->nullable();
            $table->foreign('final_city_id')->references('id')->on('cities');
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
        Schema::dropIfExists('consignments');
    }
}
