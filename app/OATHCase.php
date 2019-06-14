<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OATHCase extends Model
{
    //
    protected $table = 'oath_cases'; 

    protected $fillable = [ 
    	'property_id', 
    	'ticket_number', 
    	'violation_date', 
    	'violation_time', 
    	'issuing_agency', 
    	'respondent_first_name', 
    	'respondent_last_name', 
    	'balance_due', 
    	'violation_location_borough', 
    	'violation_location_block_no', 
    	'violation_location_lot_no', 
    	'violation_location_house', 
    	'violation_location_street_name', 
    	'violation_location_floor', 
    	'violation_location_city', 
    	'violation_location_zip_code', 
    	'violation_location_state_name', 
    	'respondent_address_borough', 
    	'respondent_address_house', 
    	'respondent_address_street', 
    	'respondent_address_city', 
    	'respondent_address_zip_code', 
    	'respondent_address_state_name', 
    	'hearing_status', 
    	'hearing_result', 
    	'scheduled_hearing_location',
    	'hearing_date', 
    	'hearing_time', 
    	'decision_location_borough', 
    	'decision_date', 
    	'total_violation_amount', 
    	'violation_details', 
    	'date_judgement_docketed', 
    	'respondent_address_or_facility_number_for_fdny_and_dob_tickets', 
    	'penalty_imposed', 
    	'paid_amount', 
    	'additional_penalties_late_fees', 
    	'compliance_status', 
    	'violation_description', 
    	'updated_at', 
    	'created_at'
    ];

    public function property () 
    { 
        return $this->belongsTo('App\Property');
    }

    public function oath_case_ext () 
    { 
        return $this->hasOne('App\OATHCase2', 'id');
    }
}
