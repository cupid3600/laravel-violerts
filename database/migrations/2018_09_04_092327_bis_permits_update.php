<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BisPermitsUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('bis_permits', function(Blueprint $table){ 
            $table->string('number_doc_type')->nullable(); 
            $table->longText('url')->nullable();
            $table->dropColumn('history_uri');
            $table->longText('history_url')->nullable(); 
            $table->longText('dob_now_inspection_uri')->nullable();
            $table->string('issued')->nullable();
            $table->renameColumn('expires_date', 'expires');
            $table->renameColumn('proposed_job_start_date', 'proposed_job_start');
            $table->renameColumn('work_approved_date', 'work_approved');
            $table->string('general_contractor_registered')->nullable(); 
            $table->string('business_name')->nullable();
            $table->string('business_address')->nullable();          
            $table->dropColumn('use');
            $table->dropColumn('landmark');
            $table->dropColumn('stories');
            $table->dropColumn('site_fill');
            $table->dropColumn('review_is_requested_under_building_code');
            $table->dropColumn('adding_more_than_3_stories');
            $table->dropColumn('removing_one_or_more_stories');
            $table->dropColumn('performing_work_in_50_percent_or_more_of_building_area');
            $table->dropColumn('demolishing_50_percent_or_more_of_building_area');
            $table->dropColumn('performing_vertical_horizontal_enlargement');
            $table->dropColumn('mechanical_equipment_to_be_used_for_demolition');
            $table->dropColumn('mech_equipment_other_than_handheld');
            $table->dropColumn('approved_work_includes_concrete');
            $table->dropColumn('concrete_work_completed');
            $table->dropColumn('requesting_concrete_exclusion');
            $table->dropColumn('work_includes_2000_cubic_yds_or_more_of_concrete');
            $table->dropColumn('gc_safety_registration');
            $table->dropColumn('gc_safety_registration_uri');
            $table->dropColumn('job_number_uri'); 
            $table->dropColumn('permit_number');
            $table->dropColumn('issued_date');
            $table->dropColumn('work_description');
            $table->dropColumn('permit_uri');
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
