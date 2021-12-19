<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('login')->unique();
            $table->string('password')->nullable();
            $table->integer('user')->nullable();
            $table->integer('admin')->nullable();
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
            $table->string('manager_id')->nullable();
            $table->string('manager_emails')->nullable();
            $table->string('verify')->default(0);
            $table->integer('verify_by')->nullable();
            $table->integer('status')->nullable();
            $table->integer('status_by')->nullable();
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
        Schema::dropIfExists('users');
    }
}
