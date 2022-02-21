<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_emails', function (Blueprint $table) {
            $table->id();
            $table->string('to');
            $table->string('cc');
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->string('document')->nullable();
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
        Schema::dropIfExists('schedule_emails');
    }
}
