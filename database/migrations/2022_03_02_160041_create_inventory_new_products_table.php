<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryNewProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_new_products', function (Blueprint $table) {
            $table->id();
            $table->integer('cat_id')->nullable();
            $table->integer('subcat_id')->nullable();
            $table->string('name')->nullable();
            $table->string('serial')->nullable();
            $table->string('remarks')->nullable();
            $table->string('document')->nullable();
            $table->date('purchase')->nullable();
            $table->date('warranty')->nullable();
            $table->string('invoice_num')->nullable();
            $table->date('bill_submit')->nullable();
            $table->string('req_payment_num')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('give_st')->default(0);
            $table->integer('po_number')->nullable();
            $table->integer('delete_temp')->default(0);
            $table->integer('delete_by')->default(0);
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
        Schema::dropIfExists('inventory_new_products');
    }
}
