<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BISPlumbingInspectionPermit extends Model
{
    //
    protected $table = 'b_i_s_plumbing_inspection_permits';

    protected $fillable = [
    	'property_id',
	    'inspection_date',
	    'inspection_status',
	    'status_date',
	    'work_order',
	    'work_order_uri',
	    'pltype',
	    'plid',
	    'name',

        //update by kemel - needs to be add to migration
        'job_number', 
        'job_number_uri', 
        'badge', 
        'gas',
        'status',
        'permit_number', 
        'permit_uri',
        //end of update by kemel

    	'created_at',
    	'updated_at'
    ];

    public function property ()
    { 
    	return $this->belongsTo('App\Property');
    }
}
