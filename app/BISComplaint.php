<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISComplaint extends Model
{
    //
    protected $table = 'bis_complaints'; 

    protected $fillable = [ 
    	'property_id',

        # collected within index request 
    	'complaint_number',
		'url', // change to url from uri
		'address', 
		'date_entered',
		'category',
		'inspection_date',
        'status',
        

        # collected within record request
        'community_board',
        'priority', 
        'last_inspection',
        'badge_number', // new value
        'dob_violation_number', 
        'ecb_violation_number', 
        'comments',
        'job_number',
        'permit_number', // new value 
        'electrical_violation_number', // new value
        'description',
        'category_code', // new value
        'category_code_description', // new value 
        'assigned_to', // new value
        'received', // new value
        'owner', // new value
        'disposition',
        'disposition_date', // new value 
        'disposition_description', // new value
        'too_reference_number', // new value
        'prev_ecb_violation_number', // new value
        'prev_dob_violation_number', // new value


        'active',
         
        
         


    	'created_at', 
    	'updated_at'
    ];

    public function property ()
    { 
    	return $this->belongsTo('App\Property');
    }
}
