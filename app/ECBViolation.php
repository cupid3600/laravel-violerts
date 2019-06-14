<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ECBViolation extends Model
{
    //
    protected $table = 'ecb_violations'; 

    protected $fillable = [ 
    	'property_id',
    	'isn_dob_bis_extract',
    	'ecb_violation_number', 
    	'ecb_violation_status', 
    	'ecb_dob_violation_number', 
    	'bin', 
    	'boro', 
    	'block', 
    	'lot', 
    	'hearing_date', 
    	'hearing_time', 
    	'served_date', 
    	'issue_date', 
    	'severity', 
    	'violation_type', 
    	'respondent_name', 
    	'respondent_house_number', 
    	'respondent_street', 
    	'respondent_city', 
    	'respondent_zip', 
    	'violation_description', 
    	'penality_imposed',
    	'amount_paid', 
    	'balance_due', 
    	'infraction_code1', 
    	'section_law_description1',
    	'infraction_code2', 
    	'section_law_description2',
    	'infraction_code3', 
    	'section_law_description3',
    	'infraction_code4', 
    	'section_law_description4',
    	'infraction_code5', 
    	'section_law_description5',
    	'infraction_code6', 
    	'section_law_description6',
    	'infraction_code7', 
    	'section_law_description7',
    	'infraction_code8', 
    	'section_law_description8',
    	'infraction_code9', 
    	'section_law_description9',
    	'infraction_code10', 
    	'section_law_description10',
    	'aggravated_level', 
    	'hearing_status', 
    	'certification_status'
    ];

    public function property () 
    { 
    	return $this->belongsTo('App\Property');
    }
}
