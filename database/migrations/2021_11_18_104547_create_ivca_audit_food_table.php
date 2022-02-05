<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIvcaAuditFoodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ivca_audit_food', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->integer('vendor_id');
            $table->integer('token_id');
            $table->integer('schedule_id');
            $table->date('date');
           
            $table->integer('building_facilities_a')->nullable();
            $table->string('building_facilities_a_remarks')->nullable();
            $table->string('building_facilities_a_image')->nullable();
            $table->integer('building_facilities_b')->nullable();
            $table->string('building_facilities_b_remarks')->nullable();
            $table->string('building_facilities_b_image')->nullable();
            $table->integer('building_facilities_c')->nullable();
            $table->string('building_facilities_c_remarks')->nullable();
            $table->string('building_facilities_c_image')->nullable();
            $table->integer('building_facilities_d')->nullable();
            $table->string('building_facilities_d_remarks')->nullable();
            $table->string('building_facilities_d_image')->nullable();
            $table->integer('building_facilities_e')->nullable();
            $table->string('building_facilities_e_remarks')->nullable();
            $table->string('building_facilities_e_image')->nullable();
            $table->integer('building_facilities_status')->nullable();



            $table->integer('equipment_a')->nullable();
            $table->string('equipment_a_remarks')->nullable();
            $table->string('equipment_a_image')->nullable();
            $table->integer('equipment_b')->nullable();
            $table->string('equipment_b_remarks')->nullable();
            $table->string('equipment_b_image')->nullable();
            $table->integer('equipment_c')->nullable();
            $table->string('equipment_c_remarks')->nullable();
            $table->string('equipment_c_image')->nullable();
            $table->integer('equipment_status')->nullable();




            $table->integer('personnel_a')->nullable();
            $table->string('personnel_a_remarks')->nullable();
            $table->string('personnel_a_image')->nullable();
            $table->integer('personnel_b')->nullable();
            $table->string('personnel_b_remarks')->nullable();
            $table->string('personnel_b_image')->nullable();
            $table->integer('personnel_c')->nullable();
            $table->string('personnel_c_remarks')->nullable();
            $table->string('personnel_c_image')->nullable();
            $table->integer('personnel_status')->nullable();



            $table->integer('raw_materials_a')->nullable();
            $table->string('raw_materials_a_remarks')->nullable();
            $table->string('raw_materials_a_image')->nullable();
            $table->integer('raw_materials_b')->nullable();
            $table->string('raw_materials_b_remarks')->nullable();
            $table->string('raw_materials_b_image')->nullable();
            $table->integer('raw_materials_c')->nullable();
            $table->string('raw_materials_c_remarks')->nullable();
            $table->string('raw_materials_c_image')->nullable();
            $table->integer('raw_materials_d')->nullable();
            $table->string('raw_materials_d_remarks')->nullable();
            $table->string('raw_materials_d_image')->nullable();
            $table->integer('raw_materials_e')->nullable();
            $table->string('raw_materials_e_remarks')->nullable();
            $table->string('raw_materials_e_image')->nullable();
            $table->integer('raw_materials_status')->nullable();




            $table->integer('production_a')->nullable();
            $table->string('production_a_remarks')->nullable();
            $table->string('production_a_image')->nullable();
            $table->integer('production_b')->nullable();
            $table->string('production_b_remarks')->nullable();
            $table->string('production_b_image')->nullable();
            $table->integer('production_c')->nullable();
            $table->string('production_c_remarks')->nullable();
            $table->string('production_c_image')->nullable();
            $table->integer('production_d')->nullable();
            $table->string('production_d_remarks')->nullable();
            $table->string('production_d_image')->nullable();
            $table->integer('production_e')->nullable();
            $table->string('production_e_remarks')->nullable();
            $table->string('production_e_image')->nullable();
            $table->integer('production_f')->nullable();
            $table->string('production_f_remarks')->nullable();
            $table->string('production_f_image')->nullable();
            $table->integer('production_status')->nullable();



            $table->integer('records_a')->nullable();
            $table->string('records_a_remarks')->nullable();
            $table->string('records_a_image')->nullable();
            $table->integer('records_b')->nullable();
            $table->string('records_b_remarks')->nullable();
            $table->string('records_b_image')->nullable();
            $table->integer('records_c')->nullable();
            $table->string('records_c_remarks')->nullable();
            $table->string('records_c_image')->nullable();
            $table->integer('records_d')->nullable();
            $table->string('records_d_remarks')->nullable();
            $table->string('records_d_image')->nullable();
            $table->integer('records_status')->nullable();



            $table->integer('labeling_a')->nullable();
            $table->string('labeling_a_remarks')->nullable();
            $table->string('labeling_a_image')->nullable();
            $table->integer('labeling_b')->nullable();
            $table->string('labeling_b_remarks')->nullable();
            $table->string('labeling_b_image')->nullable();
            $table->integer('labeling_c')->nullable();
            $table->string('labeling_c_remarks')->nullable();
            $table->string('labeling_c_image')->nullable();
            $table->integer('labeling_status')->nullable();
            

            $table->integer('status')->nullable();
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
        Schema::dropIfExists('ivca_audit_food');
    }
}
