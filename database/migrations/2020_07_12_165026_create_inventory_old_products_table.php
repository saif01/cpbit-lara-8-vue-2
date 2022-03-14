<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryOldProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_old_products', function (Blueprint $table) {
            $table->id();
            $table->integer('new_pro_id')->nullable();
            $table->integer('comp_id')->nullable();
            $table->integer('cat_id')->nullable();
            $table->integer('subcat_id')->nullable();
            $table->string('office')->nullable();
            $table->string('business_unit')->nullable();
            $table->integer('operation_id')->nullable();
            $table->string('name')->nullable();
            $table->string('serial')->nullable();
            $table->text('remarks')->nullable();
            $table->string('type')->nullable();
            $table->string('rec_name')->nullable();
            $table->string('rec_contact')->nullable();
            $table->string('rec_position')->nullable();
            $table->integer('status')->default(0);
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('inventory_old_products');
    }
}
