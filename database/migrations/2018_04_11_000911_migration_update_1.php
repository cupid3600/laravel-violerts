<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrationUpdate1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // bis 

        # complaints 
        Schema::table('bis_complaints', function (Blueprint $table) { 
            $table->string('last_inspection')->nullable();
            $table->string('priority')->nullable(); 
            $table->string('community_board')->nullable(); 
            $table->string('dob_violation_number')->nullable(); 
            $table->string('ecb_violation_number')->nullable(); 
            $table->string('job_number')->nullable(); 
        });

        # dob violations
        Schema::table('bis_dob_violations', function (Blueprint $table) { 
            $table->string('device_number')->nullable(); 
            $table->string('ecb_number')->nullable(); 
            $table->string('infraction_codes')->nullable(); 
            $table->string('description')->nullable(); 
            $table->string('disposition_code')->nullable(); 
            $table->string('disposition_date')->nullable(); 
            $table->string('inspector')->nullable(); 
            $table->string('comments')->nullable();
        });

        # ecb violations 
        Schema::table('bis_ecb_violations', function (Blueprint $table) { 
            $table->string('certification_status')->nullable(); 
            $table->string('hearing_status')->nullable(); 
            $table->string('mailing_address')->nullable(); 
            $table->string('served_date')->nullable(); 
            $table->string('violation_type')->nullable(); 
            $table->string('inspection_unit')->nullable(); 
            $table->string('remedy')->nullable(); 
            $table->string('issuing_inspector_id')->nullable(); 
            $table->string('dob_violation_number')->nullable(); 
            $table->string('issued_as_aggr_level')->nullable(); 
            $table->string('compliance_on')->nullable(); 
            $table->string('cert_submission_date')->nullable(); 
            $table->string('scheduled_hearing_date')->nullable(); 
            $table->string('penalty_imposed')->nullable(); 
            $table->string('adjustments')->nullable(); 
            $table->string('penalty_balance_due')->nullable(); 
            $table->string('amount_paid')->nullable();
        });

        # job applications
        Schema::table('bis_job_applications', function (Blueprint $table) { 
            $table->string('pre_filed')->nullable(); 
            $table->string('date_filed')->nullable(); 
            $table->string('fee_structure')->nullable(); 
            $table->string('review_is_requested_code')->nullable(); 
            $table->string('house_number')->nullable(); 
            $table->string('street_name')->nullable(); 
            $table->string('borough')->nullable(); 
            $table->string('work_on_floors')->nullable(); 
            $table->string('block')->nullable(); 
            $table->string('lot')->nullable(); 
            $table->string('bin')->nullable();
            $table->string('cb_number')->nullable(); 
            $table->string('condo_number')->nullable(); 
            $table->string('zipcode')->nullable(); 
            $table->string('applicant_name')->nullable(); 
            $table->string('applicant_business_name')->nullable(); 
            $table->string('applicant_business_phone')->nullable(); 
            $table->string('applicant_business_address')->nullable(); 
            $table->string('applicant_business_fax')->nullable(); 
            $table->string('applicant_email')->nullable(); 
            $table->string('applicant_mobile_phone')->nullable(); 
            $table->string('applicant_license_number')->nullable(); 
            $table->string('applicant_type')->nullable(); 
            $table->string('directive_14_applicant')->nullable(); 
            $table->string('prev_applicant_name')->nullable(); 
            $table->string('prev_applicant_business_name')->nullable(); 
            $table->string('prev_applicant_business_phone')->nullable(); 
            $table->string('prev_applicant_business_address')->nullable();  
            $table->string('prev_applicant_business_fax')->nullable(); 
            $table->string('prev_applicant_email')->nullable(); 
            $table->string('prev_applicant_mobile_phone')->nullable(); 
            $table->string('prev_applicant_type')->nullable(); 
            $table->string('prev_applicant_license_number')->nullable();
            $table->string('filing_rep_name')->nullable(); 
            $table->string('filing_rep_business_name')->nullable(); 
            $table->string('filing_rep_business_phone')->nullable();
            $table->string('filing_rep_business_address')->nullable(); 
            $table->string('filing_rep_business_fax')->nullable(); 
            $table->string('filing_rep_email')->nullable(); 
            $table->string('filing_rep_mobile_phone')->nullable(); 
            $table->string('filing_rep_registration_number')->nullable(); 
            $table->boolean('work_boiler')->default(false); 
            $table->boolean('work_fire_supression')->default(false); 
            $table->boolean('work_sprinkler')->default(false); 
            $table->boolean('work_general_construction')->default(false); 
            $table->boolean('work_fire_alarm')->default(false); 
            $table->boolean('work_mechanical')->default(false); 
            $table->boolean('work_construction_equipment')->default(false); 
            $table->boolean('work_fuel_buring')->default(false); 
            $table->boolean('work_plumbing')->default(false); 
            $table->boolean('work_curb_cut')->default(false); 
            $table->boolean('work_fuel_storage')->default(false); 
            $table->boolean('work_standpipe')->default(false); 
            $table->boolean('enlargement_proposed')->default(false); 
            $table->boolean('horizontal')->default(false); 
            $table->boolean('vertical')->default(false); 
            $table->boolean('alt_required_new_building')->default(false); 
            $table->boolean('alt_is_major')->default(false); 
            $table->boolean('change_in_dwelling_unit')->default(false); 
            $table->boolean('change_in_occupancy_use')->default(false);
            $table->boolean('change_is_inconsistent')->default(false); 
            $table->boolean('change_in_stories')->default(false); 
            $table->boolean('facade_alteration')->default(false); 
            $table->boolean('adult_estab')->default(false); 
            $table->boolean('comp_development')->default(false); 
            $table->boolean('low_income')->default(false); 
            $table->boolean('sro_multiple')->default(false); 
            $table->boolean('filing_includes_lot_merge')->default(false); 
            $table->boolean('infill_zoning')->default(false); 
            $table->boolean('loft_board')->default(false); 
            $table->boolean('quality_housing')->default(false); 
            $table->boolean('site_safety')->default(false);
            $table->boolean('included_lmccc')->default(false); 
            $table->boolean('prefab_wood')->default(false); 
            $table->boolean('structural_cold_steel')->default(false); 
            $table->boolean('open_web_steel')->default(false);
        });

        // open data

        # oath cases 
        Schema::table('oath_cases', function (Blueprint $table) { 
            $table->longText('violation_details')->nullable()->change();
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
