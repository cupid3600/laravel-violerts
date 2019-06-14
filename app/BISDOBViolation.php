<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISDOBViolation extends Model
{
    //
    protected $table = 'bis_dob_violations'; 

    protected $fillable = [ 
    	'property_id', 

        # data collected from index
    	'dob_violation_number', // changed from number to dob_violation_number
    	'url', // changed from uri to url 
    	'type',
        'status', // new value
        'file_date', // new value
        

        # data collected from record 
        'issue_date', 
        'violation_type_code', // new value
        'violation_type', // new value
        'ecb_violation_number', // changed from ecb_number to ecb_violation_number
        'infraction_codes',
        'description', 
        'violation_category', // new value
        'device_number', 
        'disposition_code', // new value
        'disposition_date', // new value
        'disposition_inspector', // changed from inspector to disposition_inspector
        'disposition_comments', // changed from comments to disposition_comments 


        'active',

    	'updated_at', 
    	'created_at'
    ];

    public function property ()
    { 
    	return $this->belongsTo('App\Property');
    }
}
