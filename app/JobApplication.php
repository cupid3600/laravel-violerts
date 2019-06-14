<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    //
    protected $table = 'job_applications';

    protected $fillable = [ 
    	'property_id',
    	'job__', 
    	'doc__', 
    	'borough', 
    	'house__', 
    	'street_name', 
    	'block', 
    	'lot', 
    	'bin__', 
        'job_type',
    	'job_status', 
    	'job_status_descrp', 
    	'latest_action_date', 
    	'building_type', 
    	'community_board', 
    	'cluster', 
    	'landmarked', 
    	'adult_estab', 
    	'loft_board', 
    	'city_owned', 
    	'little_e', 
    	'pc_filed', 
    	'efiling_filed', 
    	'plumbing', 
    	'mechanical', 
    	'boiler', 
    	'fuel_burning', 
    	'fuel_storage',
    	'standpipe', 
    	'sprinkler', 
    	'fire_alarm', 
    	'equipment', 
    	'fire_suppression', 
    	'curb_cut', 
    	'other', 
    	'other_description', 
    	'applicant_s_first_name', 
    	'applicant_s_last_name', 
    	'applicant_professional_title', 
    	'applicant_license__', 
    	'professional_cert', 
    	'pre_filing_date', 
        'updated_at',
        'created_at'
    ];

    public function property ()
    { 
    	return $this->belongsTo('App\Property');
    }

    public function job_application_ext () 
    { 
        return $this->hasOne('App\JobApplication2');
    }
}
