<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHardwareDamagedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardware_damageds', function (Blueprint $table) {
            $table->id();
            $table->integer('comp_id');
            $table->string('applicable_type', 100)->nullable();
            $table->string('damaged_type', 100)->nullable();
            $table->string('damaged_reason', 100)->nullable();
            $table->string('rep_pro_id')->nullable();
            $table->integer('apply_by')->nullable();
            $table->dateTime('apply_at')->nullable();
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
        Schema::dropIfExists('hardware_damageds');
    }
}
