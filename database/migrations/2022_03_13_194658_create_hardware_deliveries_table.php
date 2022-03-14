<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHardwareDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardware_deliveries', function (Blueprint $table) {
            $table->id();
            $table->integer('comp_id');
            $table->string('rec_name', 100)->nullable();
            $table->string('rec_contact', 100)->nullable();
            $table->string('rec_position', 100)->nullable();
            $table->text('details')->nullable();
            $table->string('document')->nullable();
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
        Schema::dropIfExists('hardware_deliveries');
    }
}
