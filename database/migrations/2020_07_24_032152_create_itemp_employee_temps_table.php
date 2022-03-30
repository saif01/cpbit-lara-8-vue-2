<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItempEmployeeTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemp_employee_temps', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->string('id_number');
            $table->string('name')->nullable();
            $table->string('department')->nullable();
            $table->date('date')->nullable();
            $table->string('temp_1')->nullable();
            $table->string('temp_2')->nullable();
            $table->string('temp_3')->nullable();
            $table->string('temp_4')->nullable();
            $table->string('temp_5')->nullable();
            $table->string('temp_final')->nullable();
            $table->string('bu_location')->nullable();
            $table->string('temp_1_by')->nullable();
            $table->string('temp_2_by')->nullable();
            $table->string('temp_3_by')->nullable();
            $table->string('temp_4_by')->nullable();
            $table->string('temp_5_by')->nullable();
            $table->string('temp_1_by_name')->nullable();
            $table->string('temp_2_by_name')->nullable();
            $table->string('temp_3_by_name')->nullable();
            $table->string('temp_4_by_name')->nullable();
            $table->string('temp_5_by_name')->nullable();
            $table->string('temp_1_location')->nullable();
            $table->string('temp_2_location')->nullable();
            $table->string('temp_3_location')->nullable();
            $table->string('temp_4_location')->nullable();
            $table->string('temp_5_location')->nullable();
            $table->string('temp_1_time')->nullable();
            $table->string('temp_2_time')->nullable();
            $table->string('temp_3_time')->nullable();
            $table->string('temp_4_time')->nullable();
            $table->string('temp_5_time')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('itemp_employee_temps');
    }
}
