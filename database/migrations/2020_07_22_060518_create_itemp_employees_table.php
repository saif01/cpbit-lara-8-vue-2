<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItempEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemp_employees', function (Blueprint $table) {
            $table->id();
            $table->string('id_number');
            $table->string('name');
            $table->string('department');
            $table->string('remarks')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('itemp_employees');
    }
}
