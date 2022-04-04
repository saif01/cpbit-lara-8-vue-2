<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePbiExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pbi_expenses', function (Blueprint $table) {
            $table->id();
            $table->date('expense_date')->nullable();
            $table->string('business')->nullable();
            $table->string('business_unit')->nullable();
            $table->string('operation')->nullable();
            $table->string('department')->nullable();
            $table->string('unit_level_code')->nullable();
            $table->string('unit_level_name')->nullable();
            $table->string('control_account_code')->nullable();
            $table->string('control_account_name')->nullable();
            $table->string('account_code')->nullable();
            $table->string('account_name')->nullable();
            $table->string('expense_type')->nullable();
            $table->string('expense_group')->nullable();
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
        Schema::dropIfExists('pbi_expenses');
    }
}
