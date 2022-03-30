<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItempOthersTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemp_others_temps', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('temp')->nullable();
            $table->string('remarks')->nullable();
            $table->string('temp_location')->nullable();
            $table->string('bu_location')->nullable();
            $table->integer('temp_by')->nullable();
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
        Schema::dropIfExists('itemp_others_temps');
    }
}
