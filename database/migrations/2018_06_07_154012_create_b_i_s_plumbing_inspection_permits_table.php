<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBISPlumbingInspectionPermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_i_s_plumbing_inspection_permits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id');
            $table->string('permit_number')->nullable();
            $table->string('permit_uri')->nullable();
            $table->string('inspection_date')->nullable();
            $table->string('inspection_status')->nullable();
            $table->string('status_date')->nullable();
            $table->string('work_order')->nullable();
            $table->string('work_order_uri')->nullable();
            $table->string('job_number')->nullable(); 
            $table->string('job_number_uri')->nullable(); 
            $table->string('badge')->nullable();
            $table->boolean('gas')->nullable(); 
            $table->string('status')->nullable();
            $table->string('pltype')->nullable();
            $table->string('plid')->nullable();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('b_i_s_plumbing_inspection_permits');
    }
}
