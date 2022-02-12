<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_complains', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('cat_id')->nullable();
            $table->integer('subcat_id')->nullable();
            $table->text('details')->nullable();
            $table->string('process')->nullable();
            $table->string('document')->nullable();
            $table->string('document2')->nullable();
            $table->string('document3')->nullable();
            $table->string('document4')->nullable();
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
        Schema::dropIfExists('application_complains');
    }
}
