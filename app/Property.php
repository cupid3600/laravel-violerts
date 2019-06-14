<?php

namespace App;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    //
    protected $table = 'properties'; 


    protected $fillable = [ 
        'id',
    	'house_number', 
    	'street_name', 
    	'borough', 
    	'address',
    	'bin', 
    	'block', 
    	'lot',
    	'source',
        'coo_uri',
        'cross_streets',
        'complaints_uri',
        'complaints_total',
        'complaints_open',
        'complaints_endpoint',
        'dob_violations_uri',
        'dob_violations_total',
        'dob_violations_open',
        'dob_violations_endpoint',
        'ecb_violations_uri',
        'ecb_violations_total',
        'ecb_violations_open',
        'ecb_violations_endpoint',
        'jobs_filings_uri',
        'jobs_filings_total',
        'jobs_filings_endpoint',
        'elevator_records_uri',
        'electrical_applications_uri',
        'permits_in_process_uri',
        'illuminated_signs_permit_uri',
        'plumbing_inspections_uri',
        'open_plumbing_jobs_uri',
        'facades_uri',
        'marquee_permits_uri',
        'boiler_records_uri',
        'dep_boiler_information_uri',
        'crane_information_uri',
        'after_hours_permit_uri',
        'ara_laa_uri', 
        'total_jobs', 
        'actions_uri', 
        'actions_total',
        'health_area', 
        'census_tract', 
        'community_board', 
        'buildings_on_lot', 
        'condo', 
        'vacant', 
        'zoning_docs_uri', 
        'challenge_results_uri', 
        'pre_bis_pa_uri', 
        'dob_special_name', 
        'dob_building_remarks', 
        'landmark_status', 
        'special_status', 
        'local_law', 
        'loft_law', 
        'sro_restricted', 
        'ta_restricted', 
        'ub_restricted', 
        'environmental_restrictions', 
        'grandfathered_sign', 
        'legal_adult_use', 
        'city_owned', 
        'additional_bins', 
        'special_district', 
        'building_classification',
    	'created_at',
    	'updated_at'
    ];

    public function portfolio () 
    { 
        return $this->hasOne('App\Portfolio');
    }

    public function complaints () 
    { 
        return $this->hasMany('App\Complaint');
    }

    public function too_complaints ()
    { 
        return $this->hasMany('App\TOOComplaint');
    }

    public function actions () 
    { 
        return $this->hasMany('App\BISAction');
    }

    public function dob_violations () 
    { 
        return $this->hasMany('App\DOBViolation');
    }

    public function ecb_violations ()
    { 
        return $this->hasMany('App\ECBViolation');
    }

    public function job_applications () 
    { 
        return $this->hasMany('App\JobApplication');
    }

    public function bis_complaints () 
    { 
        return $this->hasMany('App\BISComplaint');
    }

    public function bis_plumbing_inspection_permits ()
    {
        return $this->hasMany('App\BISPlumbingInspectionPermit');
    }

    public function bis_plumbing_inspection_work_orders ()
    {
        return $this->hasMany('App\BISPlumbingInspectionWorkOrder');
    }

    public function bis_elevators ()
    { 
        return $this->hasMany('App\BISElevator');
    }

    public function bis_electrical ()
    {
        return $this->hasMany('App\BISElectrical');
    }

    public function bis_illuminated_sign ()
    {
        return $this->hasMany('App\BISIlluminatedSign');
    }

    public function bis_dob_violations () 
    { 
        return $this->hasMany('App\BISDOBViolation');
    }

    public function bis_ecb_violations () 
    { 
        return $this->hasMany('App\BISECBViolation');
    }

    public function bis_job_applications () 
    { 
        return $this->hasMany('App\BISJobApplication');
    }

    public function oath_cases () 
    { 
        return $this->hasMany('App\OATHCase');
    }

    public function acris_rpls () 
    { 
        return $this->hasMany('App\ACRISRPL'); 
    }

    public function acris_ppls () 
    { 
        return $this->hasMany('App\ACRISPPL'); 
    }

}
