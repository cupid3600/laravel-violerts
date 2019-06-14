<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OATHCase2 extends Model
{
    //
    protected $table = 'oath_cases_2'; 

    protected $fillable = [ 
    	'oath_case_id',
	    'charge_1_code', 
		'charge_1_code_section', 
		'charge_1_code_description', 
		'charge_1_infraction_amount',
		'charge_2_code', 
		'charge_2_code_section', 
		'charge_2_code_description', 
		'charge_2_infraction_amount',
		'charge_3_code', 
		'charge_3_code_section', 
		'charge_3_code_description', 
		'charge_3_infraction_amount',
		'charge_4_code', 
		'charge_4_code_section', 
		'charge_4_code_description', 
		'charge_4_infraction_amount',
		'charge_5_code', 
		'charge_5_code_section', 
		'charge_5_code_description', 
		'charge_5_infraction_amount',
		'charge_6_code', 
		'charge_6_code_section', 
		'charge_6_code_description', 
		'charge_6_infraction_amount',
		'charge_7_code', 
		'charge_7_code_section', 
		'charge_7_code_description', 
		'charge_7_infraction_amount',
		'charge_8_code', 
		'charge_8_code_section', 
		'charge_8_code_description', 
		'charge_8_infraction_amount',
		'charge_9_code', 
		'charge_9_code_section', 
		'charge_9_code_description', 
		'charge_9_infraction_amount',
		'charge_10_code', 
		'charge_10_code_section', 
		'charge_10_code_description', 
		'charge_10_infraction_amount',
		'updated_at', 
		'created_at'
    ];
    

	public function oath_case () 
	{ 
		return $this->belongsTo('App\OATHCase', 'oath_case_id');
	}
}
