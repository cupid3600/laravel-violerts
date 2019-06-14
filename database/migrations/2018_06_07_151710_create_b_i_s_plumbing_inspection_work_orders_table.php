<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBISPlumbingInspectionWorkOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_i_s_plumbing_inspection_work_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id');
            $table->string('licensee')->nullable();
            $table->string('work_description')->nullable();
            $table->string('inspector_badge')->nullable();
            $table->string('date_inspected')->nullable();
            $table->string('inspection_results')->nullable();
            $table->string('num_meters')->nullable();
            $table->string('num_meters_location')->nullable();
            $table->string('num_risers')->nullable();
            $table->string('num_risers_location')->nullable();
            $table->string('gas_uses')->nullable();
            $table->string('comments')->nullable();
            $table->string('floor_apts_insp_area')->nullable();
            $table->string('date_of_inspection')->nullable();
            $table->string('time_scheduled')->nullable();
            $table->string('inspection_reference_num')->nullable();
            $table->string('status')->nullable();
            $table->string('type')->nullable();
            $table->string('accela_inspection_num')->nullable();
            $table->string('results_floor')->nullable();
            $table->string('results_ref_no')->nullable();
            $table->string('results_system')->nullable();
            $table->string('results_component')->nullable();
            $table->string('results_test_inspection')->nullable();
            $table->string('results_result')->nullable();
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
        Schema::dropIfExists('b_i_s_plumbing_inspection_work_orders');
    }
}
