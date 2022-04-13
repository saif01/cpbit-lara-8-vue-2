<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleEmailCmsHardwareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_email_cms_hardware', function (Blueprint $table) {
            $table->id();
            $table->string('to');
            $table->string('cc')->nullable();
            $table->string('subject')->nullable();
            $table->longText('body')->nullable();
            $table->string('document')->nullable();
            $table->integer('rem_id')->nullable();
            $table->integer('dmj_id')->nullable();
            $table->integer('deliver_id')->nullable();
            $table->integer('comp_id')->nullable();
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
        Schema::dropIfExists('schedule_email_cms_hardware');
    }
}
