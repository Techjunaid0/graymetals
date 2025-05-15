<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstructionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('instructions', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('case_datetime');
            $table->unsignedInteger('shipping_company_id');
            $table->foreign('shipping_company_id')->references('id')->on('shipping_companies');
            $table->unsignedInteger('supplier_id')->nullable();
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->unsignedInteger('consignee_id')->nullable();
            $table->foreign('consignee_id')->references('id')->on('consignees');
            $table->double('weight')->nullable();
            $table->dateTime('pickup_datetime')->nullable();
            $table->text('instructions');
            $table->enum('status', ['completed', 'processing', 'pending']);
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
        Schema::dropIfExists('instructions');
    }
}
