<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISJApplicant extends Model
{
    //
    protected $table = 'bis_j_applicants';

    protected $fillable = [ 
    	'name', 
    	'business_name', 
    	'business_phone', 
    	'business_address', 
    	'business_fax', 
    	'email', 
    	'mobile_phone', 
    	'license_number', 
    	'applicant_type'
    ];

    public function job_applications ()
    { 
        return $this->hasMany('App\BISJobApplication');
    }
}
