<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PropertyMigrationUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('properties', function(Blueprint $table) { 
            $table->string('ara_laa_uri')->nullable();
            $table->string('total_jobs')->nullable();
            $table->string('actions_uri')->nullable();
            $table->string('actions_total')->nullable();
            $table->string('health_area')->nullable();
            $table->string('census_tract')->nullable();
            $table->string('community_board')->nullable();
            $table->string('buildings_on_lot')->nullable();
            $table->string('condo')->nullable();
            $table->string('vacant')->nullable();
            $table->string('zoning_docs_uri')->nullable();
            $table->string('challenge_results_uri')->nullable();
            $table->string('pre_bis_pa_uri')->nullable();
            $table->string('dob_special_name')->nullable();
            $table->string('dob_building_remarks')->nullable();
            $table->string('landmark_status')->nullable();
            $table->string('special_status')->nullable();
            $table->string('local_law')->nullable();
            $table->string('loft_law')->nullable();
            $table->string('sro_restricted')->nullable();
            $table->string('ta_restricted')->nullable();
            $table->string('ub_restricted')->nullable();
            $table->string('environmental_restrictions')->nullable();
            $table->string('grandfathered_sign')->nullable();
            $table->string('legal_adult_use')->nullable();
            $table->string('city_owned')->nullable();
            $table->string('additional_bins')->nullable();
            $table->string('special_district')->nullable();
            $table->string('building_classification')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
