<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class JobApplications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('job_applications', function (Blueprint $table) { 
            $table->increments('id'); 
            $table->string('property_id')->nullable(); 
            $table->string('job__')->nullable();
            $table->string('doc__')->nullable();
            $table->string('borough', 20)->nullable();
            $table->string('house__')->nullable();
            $table->string('street_name')->nullable();
            $table->string('block', 6)->nullable();
            $table->string('lot', 6)->nullable();
            $table->string('bin__', 8)->nullable();
            $table->string('job_type')->nullable();
            $table->string('job_status', 3)->nullable();
            $table->string('job_status_descrp', 60)->nullable();
            $table->string('latest_action_date', 18)->nullable();
            $table->string('building_type', 20)->nullable();
            $table->string('community_board', 5)->nullable();
            $table->string('cluster', 20)->nullable();
            $table->string('landmarked', 20)->nullable();
            $table->string('adult_estab', 6)->nullable();
            $table->string('loft_board', 30)->nullable();
            $table->string('city_owned')->nullable();
            $table->string('little_e', 50)->nullable();
            $table->string('pc_filed', 10)->nullable();
            $table->string('efiling_filed')->nullable();
            $table->string('plumbing', 100)->nullable();
            $table->string('mechanical', 100)->nullable();
            $table->string('boiler', 100)->nullable();
            $table->string('fuel_burning', 30)->nullable();
            $table->string('fuel_storage', 30)->nullable();
            $table->string('standpipe', 30)->nullable();
            $table->string('sprinkler', 30)->nullable();
            $table->string('fire_alarm', 30)->nullable();
            $table->string('equipment', 30)->nullable();
            $table->string('fire_suppression', 30)->nullable();
            $table->string('curb_cut', 30)->nullable();
            $table->string('other', 30)->nullable();
            $table->string('other_description')->nullable();
            $table->string('applicant_s_first_name')->nullable();
            $table->string('applicant_s_last_name')->nullable();
            $table->string('applicant_professional_title')->nullable();
            $table->string('applicant_license__')->nullable();
            $table->string('professional_cert')->nullable();
            $table->string('pre_filing_date')->nullable();


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
        Schema::dropIfExists('job_applications');
    }
}