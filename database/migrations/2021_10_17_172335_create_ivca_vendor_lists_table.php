<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIvcaVendorListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ivca_vendor_lists', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('vendor_number');
            $table->string('suppier_name')->nullable();
            $table->string('address')->nullable();
            $table->string('contact_name', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('telephone', 100)->nullable();
            $table->integer('status')->nullable();
            $table->integer('status_by')->nullable();
            $table->integer('blocked')->nullable();
            $table->integer('blocked_by')->nullable();
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
        Schema::dropIfExists('ivca_vendor_lists');
    }
}
