<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIvcaAuditMroImportersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ivca_audit_mro_importers', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->integer('vendor_id');
            $table->integer('token_id');
            $table->integer('schedule_id');
            $table->date('date');
            $table->string('type');
            
            $table->integer('storage_1')->nullable();
            $table->string('storage_1_remarks')->nullable();
            $table->integer('storage_2')->nullable();
            $table->string('storage_2_remarks')->nullable();
            $table->integer('storage_3')->nullable();
            $table->string('storage_3_remarks')->nullable();
            $table->integer('storage_4')->nullable();
            $table->string('storage_4_remarks')->nullable();
            $table->string('storage_image')->nullable();
            $table->string('storage_status')->nullable();

            $table->integer('production_qs_1')->nullable();
            $table->string('production_qs_1_remarks')->nullable();
            $table->integer('production_qs_2')->nullable();
            $table->string('production_qs_2_remarks')->nullable();
            $table->integer('production_qs_3')->nullable();
            $table->string('production_qs_3_remarks')->nullable();
            $table->integer('production_qs_4')->nullable();
            $table->string('production_qs_4_remarks')->nullable();
            $table->string('production_qs_image')->nullable();
            $table->string('production_qs_status')->nullable();

            $table->integer('safety_1')->nullable();
            $table->string('safety_1_remarks')->nullable();
            $table->integer('safety_2')->nullable();
            $table->string('safety_2_remarks')->nullable();
            $table->integer('safety_3')->nullable();
            $table->string('safety_3_remarks')->nullable();
            $table->integer('safety_4')->nullable();
            $table->string('safety_4_remarks')->nullable();
            $table->string('safety_image')->nullable();
            $table->string('safety_status')->nullable();

            $table->integer('env_sur_con_1')->nullable();
            $table->string('env_sur_con_1_remarks')->nullable();
            $table->integer('env_sur_con_2')->nullable();
            $table->string('env_sur_con_2_remarks')->nullable();
            $table->integer('env_sur_con_3')->nullable();
            $table->string('env_sur_con_3_remarks')->nullable();
            $table->integer('env_sur_con_4')->nullable();
            $table->string('env_sur_con_4_remarks')->nullable();
            $table->string('env_sur_con_image')->nullable();
            $table->string('env_sur_con_status')->nullable();

            $table->integer('cooperate_1')->nullable();
            $table->string('cooperate_1_remarks')->nullable();
            $table->integer('cooperate_2')->nullable();
            $table->string('cooperate_2_remarks')->nullable();
            $table->integer('cooperate_3')->nullable();
            $table->string('cooperate_3_remarks')->nullable();
            $table->string('cooperate_image')->nullable();
            $table->string('cooperate_status')->nullable();

            $table->string('group_image')->nullable();
            $table->string('vendor_image')->nullable();

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
        Schema::dropIfExists('ivca_audit_mro_importers');
    }
}
