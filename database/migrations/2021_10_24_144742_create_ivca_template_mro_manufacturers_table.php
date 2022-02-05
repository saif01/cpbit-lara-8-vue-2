<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIvcaTemplateMroManufacturersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ivca_template_mro_manufacturers', function (Blueprint $table) {
            $table->id();
            $table->string('storage_1')->nullable();
            $table->string('storage_2')->nullable();
            $table->string('storage_3')->nullable();
            $table->string('storage_4')->nullable();
            $table->string('production_qs_1')->nullable();
            $table->string('production_qs_2')->nullable();
            $table->string('production_qs_3')->nullable();
            $table->string('production_qs_4')->nullable();
            $table->string('safety_1')->nullable();
            $table->string('safety_2')->nullable();
            $table->string('safety_3')->nullable();
            $table->string('safety_4')->nullable();
            $table->string('env_sur_con_1')->nullable();
            $table->string('env_sur_con_2')->nullable();
            $table->string('env_sur_con_3')->nullable();
            $table->string('env_sur_con_4')->nullable();
            $table->string('equipment_1')->nullable();
            $table->string('equipment_2')->nullable();
            $table->string('equipment_3')->nullable();
            $table->string('cooperate_1')->nullable();
            $table->string('cooperate_2')->nullable();
            $table->string('cooperate_3')->nullable();
            $table->integer('status')->nullable();
            $table->integer('status_by')->nullable();
            $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('ivca_template_mro_manufacturers');
    }
}
