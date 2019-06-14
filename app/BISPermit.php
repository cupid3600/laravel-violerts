<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISPermit extends Model
{
    //
    protected $table = 'bis_permits';

    protected $fillable = [
        'property_id',
    	'bis_job_application_id',
        


        # collected from index 
        'number_doc_type', // new value
        'url', // change from uri to url 
        'history_url', // change from history_uri to history_url
        'seq_no',
        'first_issue_date', 
        'last_issue_date',
        'status',
        'applicant',

        # collected from recrd
        'dob_now_inspection_uri', // new value
        'job_number',
        'fee',
        'issued', // new value
    	'expires', // change from expires_date to exipres
        'filing_date',
        'proposed_job_start', // change from proposed_job_start_date to proposed_job_start
        'work_approved', // change from work_approved_date to work_approved
    	'issued_to',
        
        'general_contractor_registered', // new value
        'business_name', // new value
        'business_address', // new value
        'phone',
    	
        
    	
    	
        
    	
    	
    	
    	
    	
    	
        # remove
    	/*'use',
    	'landmark',
    	'stories',
    	'site_fill',
    	'review_is_requested_under_building_code',
    	'adding_more_than_3_stories',
		'removing_one_or_more_stories',
		'performing_work_in_50_percent_or_more_of_building_area',
		'demolishing_50_percent_or_more_of_building_area',
		'performing_vertical_horizontal_enlargement',
		'mechanical_equipment_to_be_used_for_demolition',
        'mech_equipment_other_than_handheld',
		'approved_work_includes_concrete',
		'concrete_work_completed',
        'requesting_concrete_exclusion',
		'work_includes_2000_cubic_yds_or_more_of_concrete',
    	
    	'gc_safety_registration',
        'gc_safety_registration_uri',
    	'business',
    	'phone'
        'job_number_uri', // remove
        'permit_number', // remove
        'issued_date', // remove
        'work_description', // remove
        'permit_uri', // remove
        */

        
    ];

    public function job_application ()
    {
    	return $this->belongsTo('App\BISJobApplication', 'bis_job_application_id');
    }
}
