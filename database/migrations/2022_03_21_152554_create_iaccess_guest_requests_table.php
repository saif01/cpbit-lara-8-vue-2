<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIaccessGuestRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('iaccess_guest_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('branch')->nullable();
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->string('mobile')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('guest_company')->nullable();
            $table->integer('no_of_guest')->nullable();
            $table->string('guest_job')->nullable();
            $table->integer('guest_duration')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // user
            $table->string('signature')->nullable();
            $table->dateTime('date')->nullable();

            // agreed by manager
            $table->string('manager_name')->nullable();
            $table->string('manager_signature')->nullable();
            $table->dateTime('manager_date')->nullable();

            // approved by bu head
            $table->string('bu_name')->nullable();
            $table->string('bu_signature')->nullable();
            $table->dateTime('bu_date')->nullable();

            // received by cpb it
            $table->string('it_name')->nullable();
            $table->string('it_signature')->nullable();
            $table->dateTime('it_date')->nullable();

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
        Schema::dropIfExists('iaccess_guest_requests');
    }
}
