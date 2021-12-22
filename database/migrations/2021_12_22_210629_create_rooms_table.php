<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('capacity')->nullable();
            $table->integer('projector')->nullable();
            $table->string('image')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->integer('delete_temp')->default(0);
            $table->integer('delete_by')->nullable();
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
        Schema::dropIfExists('rooms');
    }
}
