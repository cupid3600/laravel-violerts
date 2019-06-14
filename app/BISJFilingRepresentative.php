<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISJFilingRepresentative extends Model
{
    //
    protected $table = 'bis_j_filing_representatives'; 

    protected $fillable = [ 
    	'name', 
    	'business_name', 
    	'business_phone', 
    	'business_address', 
    	'business_fax', 
    	'email', 
    	'mobile_phone', 
    	'registration_number'
    ];

    public function job_applications () 
    { 
    	return $this->hasMany('App\BISJobApplication');
    }

}
