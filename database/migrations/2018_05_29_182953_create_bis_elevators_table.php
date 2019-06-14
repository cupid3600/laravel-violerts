<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBisElevatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bis_elevators', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id');
            $table->string('elevator_record_number')->nullable();
            $table->string('elevator_devices_uri')->nullable();
            $table->string('elevator_inspections_uri')->nullable();
            $table->string('elevator_violations_uri')->nullable();
            $table->string('device_number')->nullable();
            $table->string('device_number_uri')->nullable();
            $table->string('device_type')->nullable();
            $table->string('record')->nullable();
            $table->string('device_status')->nullable();
            $table->string('status_date')->nullable();
            $table->string('stat_comm')->nullable();
            $table->string('approval_date')->nullable();
            $table->string('alteration')->nullable();
            $table->string('floor_from')->nullable();
            $table->string('floor_to')->nullable();
            $table->string('travel_distance')->nullable();
            $table->string('speed_fpm')->nullable();
            $table->string('car_entrances')->nullable();
            $table->string('capacity_lbs')->nullable();
            $table->string('hoist_ropes_quantity')->nullable();
            $table->string('hoist_ropes_size')->nullable();
            $table->string('hoist_ropes_kind')->nullable();
            $table->string('car_cntwt_ropes_quantity')->nullable();
            $table->string('car_cntwt_ropes_size')->nullable();
            $table->string('car_cntwt_ropes_kind')->nullable();
            $table->string('machn_cntwt_ropes_quantity')->nullable();
            $table->string('machn_cntwt_ropes_size')->nullable();
            $table->string('machn_cntwt_ropes_kind')->nullable();
            $table->string('backdrum_ropes_quantity')->nullable();
            $table->string('backdrum_ropes_size')->nullable();
            $table->string('backdrum_ropes_kind')->nullable();
            $table->string('governor_ropes_quantity')->nullable();
            $table->string('governor_ropes_size')->nullable();
            $table->string('governor_ropes_kind')->nullable();
            $table->string('governor_type')->nullable();
            $table->string('safety_type')->nullable();
            $table->string('machine_type')->nullable();
            $table->string('mode_operation')->nullable();
            $table->string('car_buffer_type')->nullable();
            $table->string('firemans_service')->nullable();
            $table->string('working_pressure')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('bis_elevators');
    }
}
