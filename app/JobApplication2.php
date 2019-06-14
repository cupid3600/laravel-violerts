<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobApplication2 extends Model
{
    //
    protected $table = 'job_applications_2'; 

    protected $fillable = [ 
    	'job_application_id',
	    'paid', 
		'fully_paid', 
		'assigned', 
		'approved', 
		'fully_permitted', 
		'initial_cost', 
		'total_est_fee', 
		'fee_status', 
		'existing_zoning_sqft', 
		'proposed_zoning_sqft', 
		'horizontal_enlrgmt', 
		'vertical_enlrgmt', 
		'enlargement_sq_footage', 
		'street_frontage', 
		'existingno_of_stories', 
		'proposed_no_of_stories', 
		'existing_height', 
		'proposed_height', 
		'existing_dwelling_units', 
		'proposed_dwelling_units', 
		'existing_occupancy', 
		'proposed_occupancy', 
		'site_fill', 
		'zoning_dist1',
		'zoning_dist2',
		'zoning_dist3',
		'special_dist_1', 
		'special_dist_2', 
		'owner_type', 
		'non_profit', 
		'owner_s_first_name', 
		'owner_s_last_name', 
		'owner_s_business_name', 
		'owner_s_house_number', 
		'owner_shouse_street_name', 
		'city__', 
		'state', 
		'zip', 
		'owner_sphone', 
		'job_description', 
		'dobrundate',
		'total_construction_floor_area',
	    'updated_at',
	    'created_at'
    ];

    public function job_application () 
    { 
    	return $this->belongsTo('App\JobApplication');
    }
}
