<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIaccessInternetRequestMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iaccess_internet_request_mails', function (Blueprint $table) {
            $table->id();
            $table->string('to');
            $table->string('cc')->nullable();
            $table->string('subject')->nullable();
            $table->longText('body')->nullable();
            $table->string('document')->nullable();
            $table->string('document2')->nullable();
            $table->integer('link_id')->nullable();
            $table->integer('status')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('iaccess_internet_request_mails');
    }
}
