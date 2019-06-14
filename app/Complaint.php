<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    //
    protected $table = 'complaints'; 

    protected $fillable = [ 
    	'property_id', 
    	'complaint_number', 
    	'status', 
    	'date_entered', 
    	'house_number', 
    	'zip_code', 
    	'house_street', 
    	'bin', 
    	'community_board', 
    	'special_district', 
    	'complaint_category', 
    	'unit', 
    	'disposition_date', 
    	'disposition_code', 
    	'inspection_date', 
    	'dobrundate'
    ];

    public function property ()
    { 
    	return $this->belongsTo('App\Property');
    }
}
