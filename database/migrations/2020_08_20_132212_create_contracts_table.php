<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('invoice_no')->nullable();
            $table->string('contract_no')->nullable();
            $table->date('contract_date')->nullable();
            $table->string('supplier_name')->nullable();
            $table->integer('no_of_containers')->nullable();
            $table->integer('rate')->nullable();
            $table->string('status')->nullable();
            $table->string('shipping_line')->nullable();
            $table->date('eta')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('invoice_value')->nullable();
            $table->string('container_no')->nullable();
            $table->longText('comments')->nullable();
            $table->longText('other_info')->nullable();
            $table->longText('cu')->nullable();
            $table->longText('steal')->nullable();
            $table->longText('lme')->nullable();
            $table->string('payment_status')->nullable();
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
        Schema::dropIfExists('contracts');
    }
}
