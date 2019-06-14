<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISECBViolation extends Model
{
    //
    protected $table = 'bis_ecb_violations'; 

    protected $fillable = [ 
    	'property_id',

    	# data collected from index 
		'ecb_violation_number', // changed from ecb_number to ecb_violation_number
		'url', // changed from uri to url
		'buildings_violation_status', // changed from bvs_status to buildings_violation_status
		'buildings_violation_status_msg', // new value
		'respondent',
		'ecb_hearing_status', // changed from ecb_status to ecb_hearing_status
		'violation_date', // changed from viol_date to violation_date
		'infraction_codes', 
		'ecb_penalty_due',

		# data collected from record
		'severity', // new value 
		'certification_status', 
		'penalty_balance_due',
		'hearing_status', 
		'respondent_name', // new value
		'respondent_mailing_address', // changed from mailing_address to respondent_mailing_address
		'violation_date', // new value
		'violation_type',
		'served_date', 
		'inspection_unit',
		'device_type', // new value
		'device_number', // new value
		'section_of_law', // new value
		'standard_description', // new value
		'specific_violation_conditions', // new value  
		'remedy', // remove
		'issuing_inspector_id', 
		'dob_violation_number', 
		'issued_as_aggravated_level', // changed from issued_as_aggr_level to issued_as_aggravated_level
		'compliance_on', 
		'cert_submission_date', // remove 
		'scheduled_hearing_date', 
		'scheduled_hearing_time', // new value
		'penalty_imposed',
		'adjustments', 
		'amount_paid',
		

		'active',

		'created_at',
		'updated_at'
    ];

    public function property ()
    { 
    	return $this->belongsTo('App\Property');
	}
}
