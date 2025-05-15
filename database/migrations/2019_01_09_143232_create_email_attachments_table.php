<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_attachments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('email_id')->unsigned()->index();
            $table->string('orig_filename');
            $table->string('path');
            $table->string('size');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('email_id')
                  ->references('id')
                  ->on('emails')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_attachments');
    }
}
