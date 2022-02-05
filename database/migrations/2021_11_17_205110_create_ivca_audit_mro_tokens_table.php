<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIvcaAuditMroTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ivca_audit_mro_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('token');
            $table->integer('schedule_id');
            $table->integer('vendor_id');
            $table->date('date');
            $table->string('template')->nullable();
            $table->integer('audit_status')->nullable();
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
        Schema::dropIfExists('ivca_audit_mro_tokens');
    }
}
