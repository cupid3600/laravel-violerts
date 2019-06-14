<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DOBViolation extends Model
{
    //
    protected $table = 'dob_violations'; 

    protected $fillable = [ 
    	'property_id',
		'isn_dob_bis_viol',
		'boro',
		'bin',
		'block',
		'lot',
		'issue_date',
		'violation_type_code',
		'violation_number',
		'house_number',
		'street',
		'disposition_date',
		'disposition_comments',
		'device_number',
		'description',
		'ecb_number',
		'number',
		'violation_category',
		'violation_type', 
		'updated_at', 
		'created_at'

    ];

    public function property () 
    { 
    	return $this->belongsTo('App\Property');
    }
}
