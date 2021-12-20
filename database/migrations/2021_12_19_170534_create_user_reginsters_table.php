<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReginstersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_reginsters', function (Blueprint $table) {
            $table->id();
            $table->string('login')->unique();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('department')->nullable();
            $table->string('office_id')->nullable();
            $table->string('office_contact')->nullable();
            $table->string('personal_contact')->nullable();
            $table->string('office_email')->nullable();
            $table->string('personal_email')->nullable();
            $table->string('office')->nullable();
            $table->string('business_unit')->nullable();
            $table->string('nid')->nullable();
            $table->string('manager_name')->nullable();
            $table->string('manager_email')->nullable();
            $table->string('bu_name')->nullable();
            $table->string('bu_email')->nullable();
            $table->string('remarks')->nullable();
            $table->string('verify')->default(0);
            $table->integer('verify_by')->nullable();
            $table->integer('status')->nullable();
            $table->integer('status_by')->nullable();
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
        Schema::dropIfExists('user_reginsters');
    }
}
