<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JobApplications2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
     public function up () 
     { 
        Schema::create('job_applications_2', function(Blueprint $table) { 
            $table->increments('id'); 
            $table->integer('job_application_id')->nullable();
            $table->string('paid')->nullable();
            $table->string('fully_paid')->nullable();
            $table->string('assigned')->nullable();
            $table->string('approved')->nullable();
            $table->string('fully_permitted')->nullable();
            $table->string('initial_cost')->nullable();
            $table->string('total_est_fee')->nullable();
            $table->string('fee_status')->nullable();
            $table->string('existing_zoning_sqft')->nullable();
            $table->string('proposed_zoning_sqft')->nullable();
            $table->string('horizontal_enlrgmt')->nullable();
            $table->string('vertical_enlrgmt')->nullable();
            $table->string('enlargement_sq_footage')->nullable();
            $table->string('street_frontage')->nullable();
            $table->string('existingno_of_stories')->nullable();
            $table->string('proposed_no_of_stories')->nullable();
            $table->string('existing_height')->nullable();
            $table->string('proposed_height')->nullable();
            $table->string('existing_dwelling_units')->nullable();
            $table->string('proposed_dwelling_units')->nullable();
            $table->string('existing_occupancy')->nullable();
            $table->string('proposed_occupancy')->nullable();
            $table->string('site_fill')->nullable();
            $table->string('zoning_dist1')->nullable();
            $table->string('zoning_dist2')->nullable();
            $table->string('zoning_dist3')->nullable();
            $table->string('special_district_1')->nullable();
            $table->string('special_district_2')->nullable();
            $table->string('owner_type')->nullable();
            $table->string('non_profit')->nullable();
            $table->string('owner_s_first_name')->nullable();
            $table->string('owner_s_last_name')->nullable();
            $table->string('owner_s_business_name')->nullable();
            $table->string('owner_s_house_number')->nullable();
            $table->string('owner_shouse_street_name')->nullable();
            $table->string('city__')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('owner_sphone')->nullable();
            $table->longText('job_description')->nullable();
            $table->string('dobrundate')->nullable();
            $table->string('total_construction_floor_area')->nullable();
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
        //
        Schema::dropIfExists('job_applications_2');
    }
}
