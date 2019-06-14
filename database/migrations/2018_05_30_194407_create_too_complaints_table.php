<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTOOComplaintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('too_complaints', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id');
            $table->string('unique_key')->nullable();
            $table->string('created_date')->nullable();
            $table->string('closed_date')->nullable();
            $table->string('agency')->nullable();
            $table->string('agency_name')->nullable();
            $table->string('complaint_type')->nullable();
            $table->string('descriptor')->nullable();
            $table->string('location_type')->nullable();
            $table->string('incident_zip')->nullable();
            $table->string('incident_address')->nullable();
            $table->string('street_name')->nullable();
            $table->string('cross_street_1')->nullable();
            $table->string('cross_street_2')->nullable();
            $table->string('intersection_street_1')->nullable();
            $table->string('intersection_street_2')->nullable();
            $table->string('address_type')->nullable();
            $table->string('city')->nullable();
            $table->string('landmark')->nullable();
            $table->string('facility_type')->nullable();
            $table->string('status')->nullable();
            $table->string('due_date')->nullable();
            $table->text('resolution_description')->nullable();
            $table->string('resolution_action_updated_date')->nullable();
            $table->string('community_board')->nullable();
            $table->string('bbl')->nullable();
            $table->string('borough')->nullable();
            $table->string('x_coordinate_state_plane')->nullable();
            $table->string('y_coordinate_state_plane')->nullable();
            $table->string('open_data_channel_type')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

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
        Schema::dropIfExists('too_complaints');
    }
}
