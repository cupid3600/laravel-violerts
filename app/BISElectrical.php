<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISElectrical extends Model
{
    //
    protected $table = 'b_i_s_electricals';

    protected $fillable = [
    	'property_id',
    	'control_number',
    	'uri',
	    'dob_cross_streets',
	    'status',
	    'request_type',
	    'efiled',
	    'permit_issued',
	    'application_entered',
	    'job_start_date',
	    'last_change',
	    'job_end_date',
	    'appointment_status',
	    'last_inspection_by',
	    'last_inspection_by_on',
	    'field_disp',
	    'energize_recommendation',
	    'objection_disposition',
	    'license_number',
	    'license_number_uri',
	    'licensee_name',
	    'firm_number',
	    'firm_number_uri',
	    'firm_name',
	    'firm_phone',
	    'firm_address',
	    'work_started_or_filed_by_others',
	    'work_category',
	    'work_to_be_done',
	    'total_fee',
	    'other_work',
	    'work_related_new_amended_coo',
	    'job_regulated_by_nycecc',
	    'building_used_as',
	    'store_other',
	    'special_cert_approval',
	    'advisory_board_approval',
	    'owner_occup',
	    'owner_business_name',
	    'authorized_rep',
	    'relationship_to_owner',

		'up_to_100_amp_quantity',
		'up_to_100_amp_description',
		'from_101_up_to_200_amp_quantity',
		'from_101_up_to_200_amp_description',
		'from_201_up_to_600_amp_quantity',
		'from_201_up_to_600_amp_description',
		'from_601_up_to_1200_amp_quantity',
		'from_601_up_to_1200_amp_description',
		'over_1200_amp_quantity',
		'over_1200_amp_description',
		'up_to_2_conductor_quantity',
		'up_to_2_conductor_description',
		'over_2_to_10_quantity',
		'over_2_to_10_description',
		'over_10_to_250_mcm_quantity',
		'over_10_to_250_mcm_description',
		'over_250_mcm_quantity',
		'over_250_mcm_description',
		'one_phase_up_to_20_pole_brkrs_quantity',
		'one_phase_up_to_20_pole_brkrs_description',
		'one_phase_up_to_21_pole_brkrs_quantity',
		'one_phase_up_to_21_pole_brkrs_description',
		'three_phase_up_to_225_amps_quantity',
		'three_phase_up_to_225_amps_description',
		'three_phase_over_225_amps_quantity',
		'three_phase_over_225_amps_description',
		'total_elevators_escalators_material_lifts_quantity',
		'total_elevators_escalators_material_lifts_description',
		'each_additional_10_floors_or_less_quantity',
		'each_additional_10_floors_or_less_description',

		'signs_fieldconnect_field_inspect_tags',
		
		'service_meter_3_wire',
		'service_meter_4_wire',
		'service_meter_10_wire',
		'service_meter_existing_meters',
		'service_meter_new_meters',
		'service_meter_removed_meters',
		'service_meter_total_meters',
		'service_meter_power_auth_flag',
		'service_meter_objection_flag',
		'service_meter_power_requested',
		'service_meter_notice',
		'service_meter_power_issued',
		'service_meter_response',
		'service_meter_follow_up',
		'service_meter_wires_comments',
		'service_meter_contractors_comments',

		'inspection_details_uri',
		
    	'created_at',
    	'updated_at'
    ];
    
    public function property ()
    { 
    	return $this->belongsTo('App\Property');
    }

    public function bis_electrical_floor_descriptions ()
    {
    	return $this->hasMany('App\BISElectricalFloorDescription');
    }

    public function bis_electrical_inspections ()
    {
    	return $this->hasMany('App\BISElectricalInspection');
    }

    public function bis_electrical_objections ()
    {
    	return $this->hasMany('App\BISElectricalObjection');
    }
}
