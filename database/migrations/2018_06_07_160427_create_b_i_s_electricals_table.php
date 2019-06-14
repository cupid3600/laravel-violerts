<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBISElectricalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('b_i_s_electricals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_id');
            $table->string('uri')->nullable();
            $table->string('control_number')->nullable();
            $table->string('dob_cross_streets', 100)->nullable();
            $table->string('status', 100)->nullable();
            $table->string('request_type', 100)->nullable();
            $table->string('efiled', 100)->nullable();
            $table->string('permit_issued', 100)->nullable();
            $table->string('application_entered', 100)->nullable();
            $table->string('job_start_date', 100)->nullable();
            $table->string('last_change', 100)->nullable();
            $table->string('job_end_date', 100)->nullable();
            $table->string('appointment_status', 100)->nullable();
            $table->string('last_inspection_by', 100)->nullable();
            $table->string('last_inspection_by_on', 100)->nullable();
            $table->string('field_disp', 100)->nullable();
            $table->string('energize_recommendation', 100)->nullable();
            $table->string('objection_disposition', 100)->nullable();
            $table->string('license_number', 100)->nullable();
            $table->string('license_number_uri', 100)->nullable();
            $table->string('licensee_name', 100)->nullable();
            $table->string('firm_number', 100)->nullable();
            $table->string('firm_number_uri', 100)->nullable();
            $table->string('firm_name', 100)->nullable();
            $table->string('firm_phone', 100)->nullable();
            $table->string('firm_address', 100)->nullable();
            $table->string('work_started_or_filed_by_others')->nullable();
            $table->string('work_category')->nullable();
            $table->string('work_to_be_done')->nullable();
            $table->string('total_fee')->nullable();
            $table->string('other_work')->nullable();
            $table->string('work_related_new_amended_coo')->nullable();
            $table->string('job_regulated_by_nycecc')->nullable();
            $table->string('building_used_as')->nullable();
            $table->string('store_other')->nullable();
            $table->string('special_cert_approval')->nullable();
            $table->string('advisory_board_approval')->nullable();
            $table->string('owner_occup')->nullable();
            $table->string('owner_business_name')->nullable();
            $table->string('authorized_rep')->nullable();
            $table->string('relationship_to_owner')->nullable();
            $table->string('up_to_100_amp_quantity')->nullable();
            $table->string('up_to_100_amp_description')->nullable();
            $table->string('from_101_up_to_200_amp_quantity')->nullable();
            $table->string('from_101_up_to_200_amp_description')->nullable();
            $table->string('from_201_up_to_600_amp_quantity')->nullable();
            $table->string('from_201_up_to_600_amp_description')->nullable();
            $table->string('from_601_up_to_1200_amp_quantity')->nullable();
            $table->string('from_601_up_to_1200_amp_description')->nullable();
            $table->string('over_1200_amp_quantity')->nullable();
            $table->string('over_1200_amp_description')->nullable();
            $table->string('up_to_2_conductor_quantity')->nullable();
            $table->string('up_to_2_conductor_description')->nullable();
            $table->string('over_2_to_10_quantity')->nullable();
            $table->string('over_2_to_10_description')->nullable();
            $table->string('over_10_to_250_mcm_quantity')->nullable();
            $table->string('over_10_to_250_mcm_description')->nullable();
            $table->string('over_250_mcm_quantity')->nullable();
            $table->string('over_250_mcm_description')->nullable();
            $table->string('one_phase_up_to_20_pole_brkrs_quantity')->nullable();
            $table->string('one_phase_up_to_20_pole_brkrs_description')->nullable();
            $table->string('one_phase_up_to_21_pole_brkrs_quantity')->nullable();
            $table->string('one_phase_up_to_21_pole_brkrs_description')->nullable();
            $table->string('three_phase_up_to_225_amps_quantity')->nullable();
            $table->string('three_phase_up_to_225_amps_description')->nullable();
            $table->string('three_phase_over_225_amps_quantity')->nullable();
            $table->string('three_phase_over_225_amps_description')->nullable();
            $table->string('total_elevators_escalators_material_lifts_quantity')->nullable();
            $table->string('total_elevators_escalators_material_lifts_description')->nullable();
            $table->string('each_additional_10_floors_or_less_quantity')->nullable();
            $table->string('each_additional_10_floors_or_less_description')->nullable();
            $table->string('signs_fieldconnect_field_inspect_tags')->nullable();
            $table->string('service_meter_3_wire')->nullable();
            $table->string('service_meter_4_wire')->nullable();
            $table->string('service_meter_10_wire')->nullable();
            $table->string('service_meter_existing_meters')->nullable();
            $table->string('service_meter_new_meters')->nullable();
            $table->string('service_meter_removed_meters')->nullable();
            $table->string('service_meter_total_meters')->nullable();
            $table->string('service_meter_power_auth_flag')->nullable();
            $table->string('service_meter_objection_flag')->nullable();
            $table->string('service_meter_power_requested')->nullable();
            $table->string('service_meter_notice')->nullable();
            $table->string('service_meter_power_issued')->nullable();
            $table->string('service_meter_response')->nullable();
            $table->string('service_meter_follow_up')->nullable();
            $table->string('service_meter_wires_comments')->nullable();
            $table->string('service_meter_contractors_comments')->nullable();
            $table->string('inspection_details_uri')->nullable();
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
        Schema::dropIfExists('b_i_s_electricals');
    }
}
