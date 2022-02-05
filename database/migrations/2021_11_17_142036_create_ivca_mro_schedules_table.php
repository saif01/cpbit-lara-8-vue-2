<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIvcaMroSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ivca_mro_schedules', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->integer('user_id');
            $table->date('date');
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('ivca_mro_schedules');
    }
}
