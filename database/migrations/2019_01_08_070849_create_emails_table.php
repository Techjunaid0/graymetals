<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('instruction_id')->nullable();
            $table->foreign('instruction_id')->references('id')->on('instructions');
            $table->integer('other_party_id')->nullable();
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->enum('type', ['sent', 'received']);
            $table->boolean('read')->default(0);
            $table->enum('other_party_type', ['supplier', 'shipping_company','consignee']);
            $table->enum('status', ['deliverd', 'failed','bounce','pending']);
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
        Schema::dropIfExists('emails');
    }
}
