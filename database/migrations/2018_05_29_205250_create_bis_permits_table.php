<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBisPermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bis_permits', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id');
            $table->integer('bis_job_application_id');
            $table->string('job_number')->nullable();
            $table->string('job_number_uri')->nullable();
            $table->string('fee')->nullable();
            $table->string('permit_number')->nullable();
            $table->string('first_issue_date')->nullable();
            $table->string('last_issue_date')->nullable();
            $table->string('issued_date')->nullable();
            $table->string('expires_date')->nullable();
            $table->string('history')->nullable();
            $table->string('seq_no')->nullable();
            $table->string('filing_date')->nullable();
            $table->string('status')->nullable();
            $table->string('applicant')->nullable();
            $table->string('work_description')->nullable();
            $table->string('proposed_job_start_date')->nullable();
            $table->string('work_approved_date')->nullable();
            $table->string('use')->nullable();
            $table->string('landmark')->nullable();
            $table->string('stories')->nullable();
            $table->string('site_fill')->nullable();
            $table->string('review_is_requested_under_building_code')->nullable();
            $table->string('adding_more_than_3_stories')->nullable();
            $table->string('removing_one_or_more_stories')->nullable();
            $table->string('performing_work_in_50_percent_or_more_of_building_area')->nullable();
            $table->string('demolishing_50_percent_or_more_of_building_area')->nullable();
            $table->string('performing_vertical_horizontal_enlargement')->nullable();
            $table->string('mechanical_equipment_to_be_used_for_demolition')->nullable();
            $table->string('mech_equipment_other_than_handheld')->nullable();
            $table->string('approved_work_includes_concrete')->nullable();
            $table->string('concrete_work_completed')->nullable();
            $table->string('requesting_concrete_exclusion')->nullable();
            $table->string('work_includes_2000_cubic_yds_or_more_of_concrete')->nullable();
            $table->string('issued_to')->nullable();
            $table->string('gc_safety_registration')->nullable();
            $table->string('gc_safety_registration_uri')->nullable();
            $table->string('business')->nullable();
            $table->string('phone')->nullable();
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
        Schema::dropIfExists('bis_permits');
    }
}
