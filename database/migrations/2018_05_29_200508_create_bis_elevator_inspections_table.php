<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBisElevatorInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bis_elevator_inspections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id');
            $table->integer('b_i_s_elevator_id');
            $table->string('device_number')->nullable();
            $table->string('inspection_date')->nullable();
            $table->string('inspection_type')->nullable();
            $table->string('inspection_disposition')->nullable();
            $table->string('inspected_by')->nullable();
            $table->string('performing_elevator_agency')->nullable();
            $table->string('witnessing_elevator_agency')->nullable();
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
        Schema::dropIfExists('bis_elevator_inspections');
    }
}
