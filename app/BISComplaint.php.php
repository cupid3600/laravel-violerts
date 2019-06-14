<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISComplaint extends Model
{
    //
    protected $table = 'bis_complaints'; 

    protected $fillable = [ 
    	'property_id',
    	'complaint_number',
		'uri',
		'address',
		'date_entered',
		'category',
		'inspection_date',
		'disposition',
        'comments',
		'status',
		'description',
        'active',

        # updated attributes
        'last_inspection', 
        'priority', 
        'community_board', 
        'disposition',
        'dob_violation_number', 
        'ecb_violation_number', 
        'job_number', 
        # end of updated attributes


    	'created_at', 
    	'updated_at'
    ];

    public function property ()
    { 
    	return $this->belongsTo('App\Property');
    }
}
