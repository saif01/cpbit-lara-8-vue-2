<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIvcaVendorBlaclistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ivca_vendor_blaclists', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->date('start');
            $table->date('end');
            $table->text('remarks');
            $table->string('document')->nullable();
            $table->integer('status')->nullable();
            $table->integer('status_by')->nullable();
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
        Schema::dropIfExists('ivca_vendor_blaclists');
    }
}
