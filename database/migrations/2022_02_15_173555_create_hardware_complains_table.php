<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHardwareComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hardware_complains', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('cat_id')->nullable();
            $table->integer('subcat_id')->nullable();
            $table->text('details')->nullable();
            $table->string('process', 100)->nullable();
            $table->string('computer_name', 100)->nullable();
            $table->string('document')->nullable();
            $table->string('acsosoris')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('hardware_complains');
    }
}
