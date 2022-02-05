<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIvcaTemplateFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ivca_template_food', function (Blueprint $table) {
            $table->id();
            $table->string('building_facilities_a')->nullable();
            $table->string('building_facilities_b')->nullable();
            $table->string('building_facilities_c')->nullable();
            $table->string('building_facilities_d')->nullable();
            $table->string('building_facilities_e')->nullable();

            $table->string('equipment_a')->nullable();
            $table->string('equipment_b')->nullable();
            $table->string('equipment_c')->nullable();

            $table->string('personnel_a')->nullable();
            $table->string('personnel_b')->nullable();
            $table->string('personnel_c')->nullable();

            $table->string('raw_materials_a')->nullable();
            $table->string('raw_materials_b')->nullable();
            $table->string('raw_materials_c')->nullable();
            $table->string('raw_materials_d')->nullable();
            $table->string('raw_materials_e')->nullable();

            $table->string('production_a')->nullable();
            $table->string('production_b')->nullable();
            $table->string('production_c')->nullable();
            $table->string('production_d')->nullable();
            $table->string('production_e')->nullable();
            $table->string('production_f')->nullable();

            $table->string('records_a')->nullable();
            $table->string('records_b')->nullable();
            $table->string('records_c')->nullable();
            $table->string('records_d')->nullable();

            $table->string('labeling_a')->nullable();
            $table->string('labeling_b')->nullable();
            $table->string('labeling_c')->nullable();
            

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
        Schema::dropIfExists('ivca_template_food');
    }
}
