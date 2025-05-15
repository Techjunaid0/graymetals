<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class NewEmailFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emails', function(Blueprint $table){
            $table->boolean('has_attachments')->default(false)->after('type');
            $table->string('reference')->nullable()->after('has_attachments');
            $table->string('sender_reference')->nullable()->after('has_attachments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emails', function(Blueprint $table){
            $table->dropColumn(['has_attachments', 'reference']);
        });
    }
}
