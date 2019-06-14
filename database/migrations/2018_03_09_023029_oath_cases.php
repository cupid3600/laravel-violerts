<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OathCases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('oath_cases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id')->nullable();
            $table->string('ticket_number')->nullable();
            $table->string('violation_date')->nullable();
            $table->string('violation_time')->nullable();
            $table->string('issuing_agency')->nullable();
            $table->string('respondent_first_name')->nullable();
            $table->string('respondent_last_name')->nullable();
            $table->string('balance_due')->nullable();
            $table->string('violation_location_borough')->nullable();
            $table->string('violation_location_block_no')->nullable();
            $table->string('violation_location_lot_no')->nullable();
            $table->string('violation_location_house')->nullable();
            $table->string('violation_location_street_name')->nullable();
            $table->string('violation_location_floor')->nullable();
            $table->string('violation_location_city')->nullable();
            $table->string('violation_location_zip_code')->nullable();
            $table->string('violation_location_state_name')->nullable();
            $table->string('respondent_address_borough')->nullable();
            $table->string('respondent_address_house')->nullable();
            $table->string('respondent_address_street')->nullable();
            $table->string('respondent_address_city')->nullable();
            $table->string('respondent_address_zip_code')->nullable();
            $table->string('respondent_address_state_nanme')->nullable();
            $table->string('hearing_status')->nullable();
            $table->string('hearing_result')->nullable();
            $table->string('scheduled_hearing_location')->nullable();
            $table->string('hearing_date')->nullable();
            $table->string('hearing_time')->nullable();
            $table->string('decision_location_borough')->nullable();
            $table->string('decision_date')->nullable();
            $table->string('total_violation_amount')->nullable();
            $table->string('violation_details')->nullable();
            $table->string('date_judgement_docketed')->nullable();
            $table->string('respondent_address_or_facility_number_for_fdny_and_dob_tickets')->nullable();
            $table->string('penalty_imposed')->nullable(); 
            $table->string('paid_amount')->nullable();
            $table->string('additional_penalties_late_fees')->nullable();
            $table->string('compliance_status')->nullable();
            $table->string('violation_description')->nullable();
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
        Schema::dropIfExists('oath_cases');
    }
}
