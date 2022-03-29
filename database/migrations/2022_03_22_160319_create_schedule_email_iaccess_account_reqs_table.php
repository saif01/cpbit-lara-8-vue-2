<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScheduleEmailIaccessAccountReqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedule_email_iaccess_account_reqs', function (Blueprint $table) {
            $table->id();
            $table->string('to_manager')->nullable();
            $table->string('to_bu')->nullable();
            $table->string('to_it')->nullable();
            $table->string('cc')->nullable();
            $table->string('name')->nullable();
            $table->integer('account_form_id')->nullable();
            $table->string('subject')->nullable();
            $table->string('document')->nullable();
            $table->integer('manager_status')->nullable();
            $table->string('manager_name')->nullable();
            $table->datetime('manager_datetime')->nullable();
            $table->integer('bu_status')->nullable();
            $table->string('bu_name')->nullable();
            $table->datetime('bu_datetime')->nullable();
            $table->integer('it_status')->nullable();
            $table->string('it_name')->nullable();
            $table->datetime('it_datetime')->nullable();
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
        Schema::dropIfExists('schedule_email_iaccess_account_reqs');
    }
}
