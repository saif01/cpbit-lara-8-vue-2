<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePbiFarmAquaPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pbi_farm_aqua_purchases', function (Blueprint $table) {
            $table->id();
            $table->date('purchase_date')->nullable();
            $table->string('business_area')->nullable();
            $table->string('business_place')->nullable();
            $table->string('vendor_code')->nullable();
            $table->string('vendor_name')->nullable();
            $table->string('vendor_group')->nullable();
            $table->string('product_code')->nullable();
            $table->string('product_name')->nullable();
            $table->string('product_group')->nullable();
            $table->string('product_line')->nullable();
            $table->string('measurement')->nullable();
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
        Schema::dropIfExists('pbi_farm_aqua_purchases');
    }
}
