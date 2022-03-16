<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePbiFeedProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pbi_feed_productions', function (Blueprint $table) {
            $table->id();
            $table->date('production_date')->nullable();
            $table->string('plant')->nullable();
            $table->string('production_line')->nullable();
            $table->string('production_no')->nullable();
            $table->string('brand_name')->nullable();
            $table->string('product_code')->nullable();
            $table->string('product_name')->nullable();
            $table->string('packing_size')->nullable();
            $table->double('shift1_q', 15,2)->nullable();
            $table->double('shift1_w', 15,2)->nullable();
            $table->double('shift2_q', 15,2)->nullable();
            $table->double('shift2_w', 15,2)->nullable();
            $table->double('shift3_q', 15,2)->nullable();
            $table->double('shift3_w', 15,2)->nullable();
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
        Schema::dropIfExists('pbi_feed_productions');
    }
}
