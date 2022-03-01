<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleEmailCmsHardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_email_cms_hards', function (Blueprint $table) {
            $table->id();
            $table->integer('rem_id')->nullable();
            $table->string('to');
            $table->string('cc');
            $table->string('name')->nullable();
            $table->string('process')->nullable();
            $table->text('remarks')->nullable();
            $table->integer('comp_id')->nullable();
            $table->string('subject')->nullable();
            $table->string('accessories')->nullable();
            $table->string('warranty')->nullable();
            $table->string('delivery')->nullable();
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
        Schema::dropIfExists('schedule_email_cms_hards');
    }
}
