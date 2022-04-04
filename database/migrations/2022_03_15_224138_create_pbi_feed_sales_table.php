<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePbiFeedSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pbi_feed_sales', function (Blueprint $table) {
            $table->id();
            $table->date('sale_date')->nullable();
            $table->string('business_area')->nullable();
            $table->string('business_place')->nullable();
            $table->string('customer_code')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_group')->nullable();
            $table->string('customer_country')->nullable();
            $table->string('customer_zone')->nullable();
            $table->string('customer_area')->nullable();
            $table->string('customer_district')->nullable();
            $table->string('district_code')->nullable();
            $table->string('district_name')->nullable();
            $table->string('product_code')->nullable();
            $table->string('product_name')->nullable();
            $table->string('product_brand')->nullable();
            $table->string('product_type')->nullable();
            $table->string('product_phase')->nullable();
            $table->string('product_breed')->nullable();
            $table->string('product_breed_type')->nullable();
            $table->string('product_group')->nullable();
            $table->integer('quantity')->nullable();
            $table->double('weight', 15,4)->nullable();
            $table->double('amount', 15,4)->nullable();
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
        Schema::dropIfExists('pbi_feed_sales');
    }
}
